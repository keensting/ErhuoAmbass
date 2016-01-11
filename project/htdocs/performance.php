<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/15
 * Time: 10:33
 */

require_once('erhuo.php');
require_once('../../medoo/maindb.php');
class performance extends erhuoSmarty{
    protected $key;
    protected $page=20;//用于分页
    //获取用户的邀请码
    protected function get_key()
    {
        $this->key=$_GET['key'];
    }

    //获取该用户的业绩详情
    protected function performance_data()
    {
        $remote=new maindb();
        $num=$remote->count('p_user','*',array(
            'invite'=>$this->key,
        ));
        $re=$remote->select('p_user',array(
            'nickname',
            'phone',
            'auth',
        ), array(
            'invite'=>$this->key,
            'LIMIT'=>20,
        ));
        if($num!=0)
        {
            $pages=ceil($num/20);//分多少页
        }else{
            $pages=0;
        }

        //推送总数和数据
        $this->assign('data',array(
            'num'=>$num,
            'list'=>$re,
            'pages'=>$pages,
            'index'=>1,
            'key'=>$this->key,
        ));


    }


    protected function init()
    {
        $this->get_key();
        $this->performance_data();
        $this->display('performance.tpl');
    }
}
$demo=new performance();
$demo->run();