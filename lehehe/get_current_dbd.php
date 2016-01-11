<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/24
 * Time: 14:24
 */
require('medoo.php');



class get_current_dbd{


    protected function init()
    {
        $local_db=new lhh_db();
        $re=$local_db->select('dbd_list','*',array(
            'ORDER'=>'time DESC',
            'LIMIT'=>[0,1],
        ));
        if(empty($re))
        {
            echo '';
        }else{
            echo  json_encode($re[0]);
        }
    }



    function run()
    {
        $this->init();
    }

}
$demo=new get_current_dbd();
$demo->run();

