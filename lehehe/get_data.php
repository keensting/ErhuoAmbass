<?php
/**
 * Created by PhpStorm.
 * User: keensting
 * Date: 15-11-16
 * Time: 下午7:31
 */
require('medoo.php');

class lhh_get_data{
    protected $index;//起点
    protected $length=20;
    protected $local_db;

    protected function init()
    {
        $this->get_data();

    }

    protected function get_data()
    {
        $this->local_db=new lhh_db();
        $this->index=$_POST['index'];
//        $this->index=0;
        $list=$this->local_db->select('lhh_list','*',array(
            "ORDER" => "time DESC",
            'LIMIT'=>[$this->index,$this->length],
        ));
        if(!empty($list))
        {
            foreach($list as &$v)
            {
                $v['time']=date('Y/m/d-h:i:s',$v['time']);
            }
        }
//        print_r($list);


        echo json_encode($list);
    }



    function run()
    {
        $this->init();
    }
}
$demo=new lhh_get_data();
$demo->run();