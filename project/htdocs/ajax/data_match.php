<?php
/**处理大使后台的各种搜索条件，返回结果
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/14
 * Time: 15:35
 */
require_once('../../../medoo/medoo.php');
require_once('../../../medoo/maindb.php');
require_once('../../include/school_handler.php');
session_start();

$type=$_POST['type'];
$local=new medoo();//本地数据库接口
$remote=new maindb();//远端数据库接口
//根据不同的type制定不同的操作
if($type=='key')//根据key来查询特定的人的信息(管理员，大使)
{
    if($_SESSION['userinfo']['auth']==2)
    {
        echo 'auth';//大使拒绝查询
        exit;
    }
    $key=$_POST['key'];
    $begin=$_POST['begin']==''?0:$_POST['begin'];
    $end=$_POST['end']==''?9999999999:$_POST['end'];
    //转化为linux的时间戳
    if($begin!=0)
    {
        $arr = explode('/', substr($begin, 0, 10));
        $begin = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
    }
    if($end!=9999999999)
    {
        $arr = explode('/', substr($end, 0, 10));
        $end = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
    }

    $re=$local->select('ambassador','*',array(
       'AND'=>array(
           'ekey'=>$key,
           'auth[!]'=>0,//不能查到管理员
       ),
    ));

    if(empty($re[0]))//没有查询到结果
    {
        echo 'error';
    }else{
        if($re[0]['province']!=$_SESSION['userinfo']['province']&&$_SESSION['userinfo']['auth']==1)//主管查外省，越权
        {
            echo 'unauthrized';
            exit;
        }
        //key拥有者所在学校的数据
        $reg=$remote->count('p_user','*',array(
            'school'=>$re[0]['school'],
        ));
        $aut=$remote->count('p_user','*',array(
            "AND"=>array(
                'school'=>$re[0]['school'],
                'auth'=>1,
                ),
        ));
        $reg_in=$remote->count('p_user','*',array(
            "AND"=>array(
                 'school'=>$re[0]['school'],
                'invite[!]'=>'',
                ),
        ));
        $aut_in=$remote->count('p_user','*',array(
            "AND"=>array(
            'school'=>$re[0]['school'],
            'invite[!]'=>'',
            'auth'=>1,),
        ));
        $school_data=array(
            'reg'=>$reg,
            'aut'=>$aut,
            'reg_in'=>$reg_in,
            'aut_in'=>$aut_in,
            'reg_na'=>$reg-$reg_in,
            'aut_na'=>$aut-$aut_in,
        );
        $re[0]['reg']=$remote->count('p_user','*',array(
            'AND'=>array(
                'invite'=>$re[0]['ekey'],
                'reg_time[>]'=>$begin,
                'reg_time[<]'=>$end,
            ),
        ));
        $re[0]['aut']=$remote->count('p_user','*',array(
            'AND'=>array(
                'invite'=>$re[0]['ekey'],
                'auth_time[>]'=>$begin,
                'auth'=>1,
                'auth_time[<]'=>$end,
            ),
        ));
        $re[0]['my_auth']=$_SESSION['userinfo']['auth'];
        $re[0]['ord']=$local->count('orders','*',array(
            'AND'=>array(
                'ekey'=>$re[0]['ekey'],
                'u_time[>]'=>$begin,
                'u_time[<]'=>$end,
            )
        ));
        echo json_encode(array('info'=>$re[0],'data'=>$school_data,));
    }
    exit;
}elseif( $type=='school')
{   //按照学校查询
    $name=$_POST['name'];
    $begin=$_POST['begin'];
    $end=$_POST['end'];
    if($_SESSION['userinfo']['auth']==2)
    {
        $name=$_SESSION['userinfo']['school'];
    }
    if($_SESSION['userinfo']['auth']==1&&!in_array($name,$_SESSION['school']))
    {
        echo 'noschool';
        exit;
    }
    $where1=array();//sql查询的注册条件；
    $where2=array();//sql查询的认证条件；
    $where3=array();//sql查询的邀请注册条件；
    $where4=array();//sql查询的邀请认证条件；
    if(!empty($begin)&&!empty($end)) {//闭合的时间区间
        //将日期转化为unix时间戳
        $arr = explode('/', substr($begin, 0, 10));
        $begin = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);

        $arr = explode('/', substr($end, 0, 10));
        $end = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
        //时间区间设置错误
        if ($end <= $begin) {
            echo 'date';
            exit;
        }
        $where1=array(
            'AND'=>array(
                'school'=>$name,
                'reg_time[>]'=>$begin,
                'reg_time[<]'=>$end,
            )
        );
        $where2=array(
            'AND'=>array(
                'school'=>$name,
                'auth'=>1,
                'auth_time[>]'=>$begin,
                'auth_time[<]'=>$end,
            )
        );

        $where3=$where1;
        $where3['AND']['invite[!]']='';

        $where4=$where2;
        $where4['AND']['invite[!]']='';

    }
    elseif(!empty($begin)&&empty($end))//只有开始时间
    {
        $arr = explode('/', substr($begin, 0, 10));
        $begin = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
        $where1=array(
            'AND'=>array(
                'school'=>$name,
                'reg_time[>]'=>$begin,
            )
        );
        $where2=array(
            'AND'=>array(
                'school'=>$name,
                'auth'=>1,
                'auth_time[>]'=>$begin,
            )
        );

        $where3=$where1;
        $where3['AND']['invite[!]']='';

        $where4=$where2;
        $where4['AND']['invite[!]']='';
    }
    elseif(empty($begin)&&!empty($end))//只有结束日期
    {
        $arr = explode('/', substr($end, 0, 10));
        $end = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
        $where1=array(
            'AND'=>array(
                'school'=>$name,
                'reg_time[<]'=>$end,
            )
        );
        $where2=array(
            'AND'=>array(
                'school'=>$name,
                'auth'=>1,
                'auth_time[<]'=>$end,
            )
        );

        $where3=$where1;
        $where3['AND']['invite[!]']='';

        $where4=$where2;
        $where4['AND']['invite[!]']='';
    }
    else{//完整的时间区间
        $where1=array(
            'AND'=>array(
                'school'=>$name,
            )
        );
        $where2=$where1;
        $where2['AND']['auth']=1;

        $where3=$where1;
        $where3['AND']['invite[!]']='';

        $where4=$where3;
        $where4['AND']['auth']=1;
    }
    //查询
    $reg=$remote->count('p_user','*',$where1);
    $aut=$remote->count('p_user','*',$where2);
    $reg_in=$remote->count('p_user','*',$where3);
    $aut_in=$remote->count('p_user','*',$where4);
    //组装
    $result=array(
        'reg'=>$reg,
        'aut'=>$aut,
        'reg_in'=>$reg_in,
        'aut_in'=>$aut_in,
        'reg_na'=>$reg-$reg_in,
        'aut_na'=>$aut-$aut_in,
    );

    echo json_encode($result);
    exit;
}elseif($type=='area')
{
    $list=array();
    $start=$_POST['begin']==''?0:$_POST['begin'];
    $end=$_POST['end']==''?9999999999:$_POST['end'];
    //转化为linux的时间戳
    if($start!=0)
    {
        $arr = explode('/', substr($start, 0, 10));
        $start = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
    }
    if($end!=9999999999)
    {
        $arr = explode('/', substr($end, 0, 10));
        $end = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
    }

    $couter_data=array();//地区统计信息
    $area='';
    //管理员
    if($_SESSION['userinfo']['auth']==0)
    {
        $area=$_POST['name'];
        //获取该区域下的所有用户
        $list=$local->select('ambassador',array(
            'name','ekey','province','school','auth','level','b_value'
        ),array(
            'AND'=>array(
                'province'=>$area,
                'auth[>]'=>0,
            ),
        ));
        $couter_data=school_handler::manager_area_data_load($area,$start,$end);
    }
    //主管
    elseif($_SESSION['userinfo']['auth']==1)
    {
        $area=$_SESSION['userinfo']['province'];
        //获取该区域下的所有用户
        $list=$local->select('ambassador',array(
            'name','ekey','province','school','auth','level',
        ),array(
            'AND'=>array(
                'province'=>$area,
                'auth'=>2,
            ),
        ));
        $couter_data=school_handler::manager_area_data_load($area,$start,$end);
    }




    //填充信息
    foreach($list as &$v)
    {
        //订单数
        $ord=$local->count('orders','*',array(
            'AND'=>array(
                'ekey'=>$v['ekey'],
                'u_time[>]'=>$start,
                'u_time[<]'=>$end,
            )
        ));
        $v['ord']=$ord;
        //注册数
        $reg=$remote->count('p_user','*',array(
            'AND'=>array(
                'invite'=>$v['ekey'],
                'reg_time[>]'=>$start,
                'reg_time[<]'=>$end,
            ),
        ));
        $v['reg']=$reg;
        //认证数
        $aut=$remote->count('p_user','*',array(
            'AND'=>array(
                'invite'=>$v['ekey'],
                'auth_time[>]'=>$start,
                'auth'=>1,
                'auth_time[<]'=>$end,
            ),
        ));
        $v['aut']=$aut;

    }
    echo json_encode(array('list'=>$list,'counter'=>$couter_data,'area'=>$area));
    exit;


}elseif($type=='as_time')//大使按照时间段查询自己的数据
{
    $list=array();
    $start=$_POST['begin']==''?0:$_POST['begin'];
    $end=$_POST['end']==''?9999999999:$_POST['end'];
    //转化为linux的时间戳
    if($start!=0)
    {
        $arr = explode('/', substr($start, 0, 10));
        $start = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
    }
    if($end!=9999999999)
    {
        $arr = explode('/', substr($end, 0, 10));
        $end = gmmktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
    }
    if($_SESSION['userinfo']['auth']!=0) {//主管和大使查询自己的信息
        $reg = $remote->count('p_user', '*', array(
            'AND' => array(
                'invite' => $_SESSION['userinfo']['ekey'],
                'reg_time[>]' => $start,
                'reg_time[<]' => $end,
            )
        ));
        $aut = $remote->count('p_user', '*', array(
            'AND' => array(
                'invite' => $_SESSION['userinfo']['ekey'],
                'auth_time[>]' => $start,
                'auth' => 1,
                'auth_time[<]' => $end,
            ),
        ));
        $ord = $local->count('orders', '*', array(
            'AND' => array(
                'ekey' => $_SESSION['userinfo']['ekey'],
                'u_time[>]' => $start,
                'u_time[<]' => $end,
            )
        ));
        $result = array(
            'reg' => $reg,
            'aut' => $aut,
            'ord' => $ord,
        );
        echo json_encode($result);
        exit;
    }else{
    //管理员查询全局！
        $register_all = $remote->count('p_user', array('uid'), array(
            'AND'=>array(
                'reg_time[>]'=>$start,
                'reg_time[<]'=>$end,
            ),
        ));
        $authority_all = $remote->count('p_user', array('auth'), array(
            'AND'=>array(
                'auth_time[>]'=>$start,
                'auth_time[<]'=>$end,
                'auth'=>1,
            ),
        ));
        $register_invite = $remote->count('p_user', array('invite'), array(
            'AND'=>array(
                'reg_time[>]'=>$start,
                'reg_time[<]'=>$end,
                'invite[!]'=>'',
            ),
        ));
        $authority_invite = $remote->count('p_user', '*', array(
            'AND'=>array(
                'auth_time[>]'=>$start,
                'auth_time[<]'=>$end,
                'auth'=>1,
                'invite[!]'=>'',
            ),
        ));
        $counter = array(
            'register_all' => $register_all,
            'authority_all' => $authority_all,
            'register_invite' => $register_invite,
            'authority_invite' => $authority_invite,
            'register_nature' => ($register_all - $register_invite),
            'authority_nature' => ($authority_all - $authority_invite),
        );

        echo json_encode($counter);
        exit;
    }

}


