<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/13
 * Time: 10:37
 */
require_once('../../../medoo/medoo.php');
$name=$_POST['name'];
$pwd=$_POST['pwd'];

$db=new medoo();
$re=$db->select('ambassador','*',array(
   "OR"=>array(//�û������������¼
       'nickname'=>$name,
       'ekey'=>$name,
   )
));
session_start();
$_SESSION['userinfo']=$re[0];//����ʹ������Ϣд��session['userinfo']
$hash_pwd=sha1($re[0]['randdata'].$pwd);
$auth=$re[0]['auth'];//��ȡ��ǰ�û���״̬
if($auth==0)//����Ա
{
    $authorityList=array(
        'choose_time'=>true,
        'area_search'=>true,
        'school_search'=>true,
        'invited_code_search'=>true,
        'login_password'=>true,
        'view_details'=>true,
        'priority_set'=>true,
        'delete_user'=>true,
        'add_user'=>true,
        'my_team'=>true,
    );
}
elseif($auth==1)//����
{
    $authorityList=array(
        'choose_time'=>true,
        'area_search'=>false,
        'school_search'=>true,
        'invited_code_search'=>true,
        'login_password'=>false,
        'view_details'=>true,
        'priority_set'=>false,
        'delete_user'=>true,
        'add_user'=>true,
        'my_team'=>true,
    );
}
elseif($auth==2)//��ʹ
{
    $authorityList=array(
        'choose_time'=>true,
        'area_search'=>false,
        'school_search'=>true,
        'invited_code_search'=>false,
        'login_password'=>false,
        'view_details'=>true,
        'priority_set'=>false,
        'delete_user'=>false,
        'add_user'=>false,
        'my_team'=>false,
    );
}
//Ȩ��д��session
$_SESSION['authority']=$authorityList;
//û�в�ѯ����������벻��ȷ
if(empty($re)||$hash_pwd!=$re[0]['pwd'])
{
    echo 'error';
}
else{
    echo 'ok';
}

