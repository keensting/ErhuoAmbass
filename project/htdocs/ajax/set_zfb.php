<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/21
 * Time: 10:47
 */
//设置支付宝账号，返回ok说明设置成功
require_once('../../../medoo/medoo.php');
$demo=new medoo();
$name=$_POST['name'];
session_start();
$key=$_SESSION['userinfo']['ekey'];
$re=$demo->update('ambassador',array(
    'zfb_id'=>$name,
),array(
    'ekey'=>$key,
));
if($re==1)
{
    $_SESSION['userinfo']['zfb_id']=$name;
    echo 'ok';
}else{
    echo 'error';
}