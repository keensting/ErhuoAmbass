<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/13
 * Time: 11:45
 */
require_once('erhuo.php');
require_once('../../medoo/maindb.php');
require_once('../../medoo/medoo.php');
require_once('../include/school_handler.php');
//error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(255);
class main_page extends erhuoSmarty{

//    protected function addCSS()
//    {
//        $this->cssList[]=$this->filePath.'style/erhuoDS.css';
//        parent::addCSS();
//    }
    /**
     *获得统计表部分数据
     */
    protected  function get_all_data()
    {
        $medoo=new medoo();
        $db=new maindb();
        $counter=array();
        if($_SESSION['userinfo']['auth']==0) {
            $register_all = $db->count('p_user', array('uid'), array(
                'uid[>]' => 0,
            ));
            $authority_all = $db->count('p_user', array('auth'), array(
                'auth' => 1,
            ));
            $register_invite = $db->count('p_user', array('invite'), array(
                'invite[!]' => '',
            ));
            $authority_invite = $db->count('p_user', '*', array(
                'AND' => array(
                    'invite[!]' => '',
                    'auth' => 1,
                )
            ));
            $counter = array(
                'register_all' => $register_all,
                'authority_all' => $authority_all,
                'register_invite' => $register_invite,
                'authority_invite' => $authority_invite,
                'register_nature' => ($register_all - $register_invite),
                'authority_nature' => ($authority_all - $authority_invite),
            );

        }elseif($_SESSION['userinfo']['auth']==1)//主管默认显示地区的
        {
            $counter=school_handler::manager_area_data_load($_SESSION['userinfo']['province']);
        }
        elseif($_SESSION['userinfo']['auth']==2)//大使不予显示任何数据
        {
            $counter = array(
                'register_all' => 0,
                'authority_all' => 0,
                'register_invite' => 0,
                'authority_invite' => 0,
                'register_nature' => 0,
                'authority_nature' => 0,
            );
        }


        $this->assign('counter',$counter);


        //todo 根据身份推送不同的信息列表
        //list数据获取
        if($_SESSION['userinfo']['auth']==0)
        {//管理员推送所有数据
            $num=$medoo->count('ambassador','*',array(
                'auth[>]'=>0,
            ));
            $list=$medoo->select('ambassador','*',array(
                'auth[>]'=>0,
                'LIMIT'=>20,
            ));
        }elseif($_SESSION['userinfo']['auth']==1)
        {//省级主管，推送区域内数据

            $num = $medoo->count('ambassador', '*', array(
                'AND' => array(
                    'province' => $_SESSION['userinfo']['province'],
                    'auth' => 2,
                ),
            ));
            $list = $medoo->select('ambassador', '*', array(
                'AND' => array(
                    'province' => $_SESSION['userinfo']['province'],
                    'auth' => 2,
                ),
                'LIMIT' => 20,
            ));

        }elseif($_SESSION['userinfo']['auth']==2)
        {
            $num=1;
            $list=array();
        }
        unset($medoo);
        unset($db);

        $this->data_package($list,$num);//填充欠缺数据，推送到前端




//        $db=new maindb();
//        $re=$db->select('p_user','*',array(
//            'invite'=>$_SESSION['userinfo']['ekey'],
//            'LIMIT'=>1,
//        ));


    }

    /**将本地大使列表填充上注册认证信息
     * @param $list 本地大使列表
     */
    protected function data_package($list,$num)
    {
        $pages=ceil($num/20);//有多少页数据
        $db=new maindb();
        $local=new medoo();
        $lists=array();
        foreach($list as &$v)//引用数据，内部直接修改
        {

            $register=$db->count('p_user','*',array(
                'invite'=>$v['ekey'],
            ));
            $authority=$db->count('p_user','*',array(
                'AND'=>array(
                    'invite'=>$v['ekey'],
                    'auth'=>1,
                ),
            ));
            $orders=$local->count('orders','*',array(
                'ekey'=>$v['ekey'],
            ));

            $v['reg']=$register;
            $v['aut']=$authority;
            $v['ord']=$orders;
            $lists[]=$v;


        }
        unset($db);
        unset($local);
        $this->assign('list',array(
            'list'=>$lists,
            'pages'=>$pages,
            'num'=>$num,
            'index'=>1,
        ));
    }

    /**
     *获得自身的注册数和认证数&订单数,如果我是主管，将学校列表写入session
     */
    protected function get_self_counter()
    {
        $local=new medoo();
        $db=new maindb();
        $register=$db->count('p_user','*',array(
            'invite'=>$_SESSION['userinfo']['ekey'],
        ));
        $authority=$db->count('p_user','*',array(
            'AND'=>array(
                'invite'=>$_SESSION['userinfo']['ekey'],
                'auth'=>1,
            ),
        ));
        $orders=$local->count('orders','*',array('ekey'=>$_SESSION['userinfo']['ekey'],));
        unset($db);
        unset($local);
        if($_SESSION['userinfo']['auth']==1)
        {
            //主管，写入学校列表
            $_SESSION['school'] = school_handler::through_area_get_school($_SESSION['userinfo']['province']);
        }

        $_SESSION['userinfo']['register']=$register;
        $_SESSION['userinfo']['authority']=$authority;
        $_SESSION['userinfo']['orders']=$orders;
    }

    protected function init()
    {
//        echo $_SERVER['HTTP_REFERER'] ;
        session_start();
        $this->get_all_data();
        $this->get_self_counter();
//        date_default_timezone_set('Asia/Shanghai');
        $this->assign('session',$_SESSION);
        $this->display('main.tpl');
    }




}
$demo=new main_page();
$demo->run();
