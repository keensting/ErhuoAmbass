<?php
/**通过类型获取指定的数据
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/2
 * Time: 14:35
 */
require('../../../medoo/medoo.php');

class change_activity_list_type{
    protected $type;
    protected $local_db;

    //初始化相关变量
    function __construct()
    {
        $this->type=$_POST['type'];
        $this->local_db=new medoo();
    }
    //函数串列执行
    protected function init(){
        $this->execute_function();

    }

    //启动函数
    function  run()
    {
        $this->init();
    }

    protected function execute_function()
    {
        if($this->type=='all')
        {
            $list=$this->local_db->select('activity','*',array(
                'ORDER'=>'u_time DESC'
            ));
//            print_r($list);
            //分类操作
        }else if($this->type=='online')
        {
            $list=$this->local_db->select('activity','*',array(
                'state'=>1,
                'ORDER'=>'u_time DESC',
            ));
        }else if($this->type=='offline')
        {
            $list=$this->local_db->select('activity','*',array(
                'state'=>0,
                'ORDER'=>'u_time DESC',
            ));
        }else if($this->type=='amb')
        {
            $list=$this->local_db->select('activity','*',array(
                'is_open'=>1,
                'ORDER'=>'u_time DESC',
            ));
        }

        echo json_encode($list);
    }

}
$demo=new change_activity_list_type();
$demo->run();
