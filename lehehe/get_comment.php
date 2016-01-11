<?php
/**
 * Created by PhpStorm.
 * User: keensting
 * Date: 15-11-16
 * Time: 下午9:29
 */

require('medoo.php');
class lhh_get_comment{

    protected function init()
    {
//        date_default_timezone_set('PRC');
        $local_db=new lhh_db();
        $list=$local_db->select('lhh_comment','*',array(
                'lhh_id'=>$_POST['id'],

        ));
        if(empty($list))
        {
            echo 'none';
        }else
        {
            echo json_encode($list);
        }
    }

    function run()
    {
        $this->init();
    }

}
$demo=new lhh_get_comment();
$demo->run();