<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/15
 * Time: 13:54
 */
require_once('../../../medoo/maindb.php');

$page=$_POST['page'];
$key=$_POST['key'];
$remote=new maindb();
$start=($page-1)*20;
$re=$remote->select('p_user',array(
    'nickname',
    'phone',
    'auth',
),array(
    'invite'=>$key,
    'LIMIT'=>[$start,20],
));

$result=array(
    'list'=>$re,
    'index'=>$page,
);

echo json_encode($result);
