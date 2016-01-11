<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/29
 * Time: 19:33
 */
require('../../../medoo/medoo.php');

class demo_handler{
    protected $key;
    protected $local_db;

    function __construct()
    {
        $this->key=$_POST['key'];
        $this->local_db=new medoo();
    }

    function run()
    {
        $re=$this->local_db->update('salary',array(
            'is_give'=>1,
        ),array(
            'AND'=>array(
                'is_give'=>0,
                'ekey'=>$this->key,
            )
        ));
        if($re>0)//有数据改动
        {
            echo 'ok';
        }
        else{
            echo 'error';
        }
    }
}
$demo=new demo_handler();
$demo->run();