<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/28
 * Time: 13:40
 */

require('../../../medoo/medoo.php');
//require('../../../medoo/maindb.php');

class order_finder{
    protected $local;
//    protected $remote;
    protected $list;

    function __construct()
    {
        $this->local=new medoo();
    }

    function run()
    {
        $this->get_am_list_by_area();
        $this->reload_date_into_list();

    }

    protected function get_am_list_by_area()
    {
        $area=$_POST['area'];
        $this->list=$this->local->select('ambassador',array(
            'ekey','name','auth'
        ),array(
            'AND'=>array(
                'auth[>]'=>0,
                'province'=>$area,
            )
        ));
    }

    protected function reload_date_into_list()
    {

        $arr1=explode('/',substr($_POST['begin'],0,10));
        $arr2=explode(':',substr($_POST['begin'],11,19));
        $begin=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
        unset($arr1);
        unset($arr2);
        $arr1=explode('/',substr($_POST['end'],0,10));
        $arr2=explode(':',substr($_POST['end'],11,19));
        $end=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
        unset($arr1);
        unset($arr2);
        $act_id=$_POST['act_id'];

        foreach($this->list as &$v)
        {
            $orders=$this->local->count('orders',array(
               'AND'=>array(
                   'u_time[<]'=>$end,
                   'u_time[>]'=>$begin,
                   'state'=>0,//只统计未结算的订单
                   'ekey'=>$v['ekey'],
                   'act_id'=>$act_id,
               )
            ));
            $v['ord']=$orders;
            if($v['auth']==1)
            {
                $v['auth']='主管';
            }else {
                $v['auth'] = '大使';
            }
        }

        echo json_encode($this->list);


    }



}
$demo =new order_finder();
$demo->run();