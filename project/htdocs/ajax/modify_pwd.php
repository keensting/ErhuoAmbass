<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/14
 * Time: 13:55
 */

require_once('../../../medoo/medoo.php');

$rand=$_POST['rand'];
$key=$_POST['key'];
$pwd=sha1($rand.md5($_POST['pwd']));//���¼���

$db=new medoo();
//�޸����ݿ��е�����

$re=$db->update('ambassador',array(
    'randdata'=>$rand,
    'pwd'=>$pwd,
),array(
    'ekey'=>$key,
));
unset($db);
if($re==1)
{
    echo 'ok';
}
else{
    echo 'error';
}