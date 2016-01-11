<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/14
 * Time: 15:29
 */
require_once('../../../medoo/medoo.php');

$key=$_POST['key'];
$db=new medoo();
$re=$db->update('ambassador',array(
    'auth'=>1,
),array(
    'ekey'=>$key,
));
unset($db);
if($re==1)//修改了一行
{
    echo 'ok';
}
else{
    echo 'error';
}