<?php
/**处理认证结算的ajax请求
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/26
 * Time: 14:14
 */

require('../../../medoo/medoo.php');
require('../../../medoo/maindb.php');

class auth_hander{
    protected $begin;//开始时间
    protected $end;//结束时间
    protected $area;//地区
    protected $remote;//远端数据库实例
    protected $local;//本地数据库实例
    protected $default_auth_price=5;//默认每个认证给5块
    function __construct(){
        $this->remote=new maindb();
        $this->local=new medoo();
        date_default_timezone_set('PRC');
        $this->area=$_POST['area'];
        $arr1=explode('/',substr($_POST['begin'],0,10));
        $arr2=explode(':',substr($_POST['begin'],11,19));
        $this->begin=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
        unset($arr1);
        unset($arr2);
        $arr1=explode('/',substr($_POST['end'],0,10));
        $arr2=explode(':',substr($_POST['end'],11,19));
        $this->end=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
        unset($arr1);
        unset($arr2);
        if($this->begin>=$this->end)
        {
            //时间段设置错误
            echo 'time';
            exit;
        }

    }

    //运行函数
    function run()
    {
        $this->get_target_data();
    }

    //请求目标数据
    protected function get_target_data()
    {
        //获得目标大使列表
        $re=$this->local->select('ambassador',array(
            'ekey','name','auth',
        ),array(
            'AND'=>array(
                'province'=>$this->area,
                'auth[>]'=>0,
            ),
        ));
        //填充其他信息
        foreach($re as &$v)
        {
            $aut=$this->remote->count('p_user','*',array(
                'AND'=>array(
                    'invite'=>$v['ekey'],
                    'auth'=>1,
                    'auth_time[>]'=>$this->begin,
                    'auth_time[<]'=>$this->end,
                ),
            ));
            if($v['auth']==1)
            {
                $v['auth']='主管';
            }else{
                $v['auth']='大使';
            }
            $v['aut']=$aut;
            $v['d_salary']=$aut*$this->default_auth_price;
        }

        echo json_encode($re);

    }


}
$demo=new auth_hander();
$demo->run();




