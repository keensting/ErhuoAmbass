<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/14
 * Time: 14:20
 */
require_once('../../../medoo/medoo.php');
session_start();
$key=$_POST['key'];
$db=new medoo();
$item=$db->select('ambassador','*',array('ekey'=>$key));
$item[0]['operator']=$_SESSION['userinfo']['ekey'];//��¼�����ߵ�������
$db->insert('d_user',$item[0]);
$re=$db->delete('ambassador',array(
    'ekey'=>$key,
));
unset($db);
if($re==1)//ɾ����һ��
{
    echo 'ok';
}
else{
    echo 'error';
}