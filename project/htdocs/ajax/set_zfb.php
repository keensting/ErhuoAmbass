<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/21
 * Time: 10:47
 */
//����֧�����˺ţ�����ok˵�����óɹ�
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