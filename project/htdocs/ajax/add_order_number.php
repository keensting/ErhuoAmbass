<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/19
 * Time: 10:30
 */

require_once('../../../medoo/medoo.php');
require_once('../../../medoo/maindb.php');
$id=$_POST['id'];
session_start();
$key=$_SESSION['userinfo']['ekey'];//��ȡ�û���Ψһkey
$remote=new maindb();
$local=new medoo();
//��ѯһ��Զ�����ݿ⣬ƥ�䶩��״̬
$item=$remote->select('p_order','*',array(
    'id'=>$id,
));
if(empty($item))
{
    echo 'noinfo';
}elseif($item[0]['state']<2){
    echo 'unfinish';
}
else{
    //todo
    //���ܻ���Ӽ�����ʹ�������ж�������
    $sid=$item[0]['sid'];
    $sell_info=$remote->select('p_sell_goods','ccid',array('id'=>$sid));
    $ccid=$sell_info[0];
    if($ccid!=100)//�������
    {
        echo 'type';
        exit;
    }
    $check=$local->count('orders','*',array('order_id'=>$id));
    if($check==1)//�����ظ����
    {
        echo 'repeat';
        exit;
    }
    $re=$local->insert('orders',array(
        'ekey'=>$_SESSION['userinfo']['ekey'],
        'state'=>0,
        'price'=>$item[0]['price'],
        'u_time'=>time(),
        'c_time'=>$item[0]['time'],
        'order_id'=>$id,
        'type'=>0,
        'act_id'=>0,
    ));
    if($re!=0)
    {
        echo 'ok';
    }else
    {
        echo 'error';
    }
    //todo д
    //�뱾��
}
//print_r($item);
