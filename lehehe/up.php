<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/18
 * Time: 19:18
 */


require('./medoo.php');
//
class lhh_up{
    protected $local_db;

    function __construct()
    {
        $this->local_db=new lhh_db();


    }
    protected function init()
    {
//        print_r($_SERVER);

        $id=$_POST['id'];
        $uid=$_POST['uid'];
        if(empty($uid))
        {
            $addr=$_SERVER['REMOTE_ADDR'];
            $port=$_SERVER['REMOTE_PORT'];
            $ip=$addr.':'.$port;
            $uid=$ip;
        }

        if(!$this->check_repeatation($id,$uid))
        {
            //写入点赞表，
            $this->local_db->insert('lhh_up',array(
                'lhh_id'=>$id,
                'ip'=>$uid,
            ));
            //写入信息列表
            $this->local_db->update('lhh_list',array(
                'up[+]'=>1
            ),array(
                'id'=>$id,
            ));
            echo 'ok';
        }else{
            echo 'error';
        }
    }
    //判断是否已经评论过！
    protected function check_repeatation($id,$ip)
    {
        $re1=$this->local_db->select('lhh_up','*',array(
            'AND'=>array(
                'lhh_id'=>$id,
                'ip'=>$ip,
            ),
        ));
        $re2=$this->local_db->select('lhh_down','*',array(
            'AND'=>array(
                'lhh_id'=>$id,
                'ip'=>$ip,
            ),
        ));
        if(!empty($re1)||!empty($re2))
        {
            return true;
        }else
        {
            return false;
        }

    }
    function run()
    {
        $this->init();
    }

}
$demo=new lhh_up();
$demo->run();