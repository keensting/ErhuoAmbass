<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/24
 * Time: 15:08
 */

require('medoo.php');


class get_specific_dbd_comment{
    protected $page_size=20;

    protected function init()
    {
        $id=$_POST['id'];
        $index=$_POST['index'];
        $type=$_POST['type'];
        $local_db=new lhh_db();
        if($type=='rank')//排名
        {
            $re=$local_db->select('dbd_comment','*',array(
                'dbd_id'=>$id,
                'ORDER'=>['up DESC','time ASC'],
                'LIMIT'=>[0,5],
            ));
            if(!empty($re)) {
                echo json_encode($re);
            }else{
                echo 'error';
            }
        }else//普通数据
        {
            $re=$local_db->select('dbd_comment','*',array(
                'dbd_id'=>$id,
                'ORDER'=>'time DESC',
                'LIMIT'=>[$index*$this->page_size,$this->page_size],
            ));
            if(!empty($re)) {
                echo json_encode($re);
            }else{
                echo 'error';
            }
        }


    }



    function run()
    {
        $this->init();
    }
}

$demo=new get_specific_dbd_comment();
$demo->run();