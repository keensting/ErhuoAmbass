<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/12/3
 * Time: 15:05
 */
require('../../../medoo/medoo.php');
class switch_state{
    private $type;
    private $id;
    private $value;
    private $local_db;



    function run()
    {
        $this->init();
    }

    protected function init()
    {
        $this->get_post_data();
        $this->execute_operation();

    }

    protected function get_post_data()
    {
        $this->id=$_POST['id'];
        $this->type=$_POST['type'];
        if($_POST['value']==0)
        {
            $this->value=1;
        }else
        {
            $this->value=0;
        }
    }

    protected function execute_operation()
    {
        $this->local_db=new medoo();
        $re=$this->local_db->update('activity',array(
            $this->type=>$this->value,
        ),array(
            'id'=>$this->id,
        ));
//       echo $this->local_db->last_query();
//        echo $this->local_db->error();
        if($re>0)
        {
            echo 'ok';
        }else{
            echo 'error';
        }
    }
}
$demo=new  switch_state();
$demo->run();