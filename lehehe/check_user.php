<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/20
 * Time: 14:53
 */
require('../medoo/maindb.php');

$demo=new maindb();
$id=$_POST['id'];

$re=$demo->select('p_user','*',array(
    'uid'=>$id,
));
$lifeTime =3600;//生命周期为1小时
session_set_cookie_params($lifeTime);
session_start();
$_SESSION['user_info']=$re[0];//将用户信息存储起来

echo $re[0]['nickname'];