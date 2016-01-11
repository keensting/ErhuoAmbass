<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/29
 * Time: 18:24
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
        date_default_timezone_set('PRC');
        $list=$this->local_db->select('salary','*',array(
            'AND'=>array(
                'is_give'=>0,
                'ekey'=>$this->key,
            )

        ));
        foreach($list as &$v)
        {
            $v['time']=date('Y-m-d H:i:sa',$v['time']);
            if($v['type']==1)
            {
                $v['type']='普通身份工资';
            }elseif($v['type']==2)
            {
                $v['type']='订单工资';
            }else{
                $v['type']='认证工资';
            }
        }
        echo json_encode($list);
    }

}
$demo=new demo_handler();
$demo->run();

