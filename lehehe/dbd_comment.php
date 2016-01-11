<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/24
 * Time: 17:08
 */

require('medoo.php');

class dbd_comment
{
    protected function init()
    {
        session_start();
        if(empty($_SESSION['user_info'])||empty($_POST['content']))
        {
            echo 'error';
            exit;
        }else
        {
            $content=$_POST['content'];
            $id=$_POST['id'];
            $name=$_SESSION['user_info']['nickname'];
            $header=$_SESSION['user_info']['header'];
            if(empty($header))
            {
                $header='http://7xngw8.com1.z0.glb.clouddn.com/title.png';//默认头像
            }
            $local_db=new lhh_db();
            //检验是不是重复参与的，并计入参与人数
            $num=$local_db->count('dbd_comment','*',array(
                'AND'=>array(
                    'u_name'=>$name,
                    'dbd_id'=>$id,
                )
            ));
            if(empty($num))
            {
                $local_db->update('dbd_list',array(
                    'count[+]'=>1,
                ),array(
                    'id'=>$id,
                ));
            }

            date_default_timezone_set('PRC');
            $re=$local_db->insert('dbd_comment',array(
                'u_name'=>$name,
                'header'=>$header,
                'dbd_id'=>$id,
                'content'=>$content,
                'time'=>time(),
                'up'=>0,
            ));
            if($re>0)
            {
                echo 'ok';
            }else
            {
                echo 'fail';
            }
        }
    }

    function run()
    {
        $this->init();
    }
}
$demo=new dbd_comment();
$demo->run();