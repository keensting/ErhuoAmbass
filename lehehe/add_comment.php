<?php
/**
 * Created by PhpStorm.
 * User: keensting
 * Date: 15-11-16
 * Time: 下午8:42
 */
require('medoo.php');
class lhh_add_comment{

    protected function init()
    {
        date_default_timezone_set('PRC');
        $local_db=new lhh_db();
        $re=$local_db->insert('lhh_comment',array(
            'u_name'=>$_POST['name'],
            'lhh_id'=>$_POST['id'],
            'time'=>time(),
            'content'=>$_POST['text'],
        ));
        if(!empty($re))
        {
            echo 'ok';
        }else{
            echo 'error';
        }
    }

    function run()
    {
        $this->init();
    }

}
$demo=new lhh_add_comment();
$demo->run();