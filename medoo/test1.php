<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/24
 * Time: 0:57
 */
//require('medoo.php');
//$local=new medoo();
//$orders=$local->count('orders','*',array(
//    'AND'=>array(
//        'u_time[<]'=>9999999999,
//        'u_time[>]'=>0,
//        'state'=>0,//只统计未结算的订单
//        'ekey'=>'230230',
//        'act_id'=>0,
//    )));
//echo 'dasd';
//print_r($orders);

require('maindb.php');
$demo=new maindb();
$list=$demo->select('p_user','*',array(
    'phone'=>'13121062200',
));
print_r($list);