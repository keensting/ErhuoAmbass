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
   "OR"=>array(//用户名或邀请码登录
       'nickname'=>$name,
       'ekey'=>$name,
   )
));
session_start();
$_SESSION['userinfo']=$re[0];//将大使基本信息写入session['userinfo']
$hash_pwd=sha1($re[0]['randdata'].$pwd);
$auth=$re[0]['auth'];//获取当前用户的状态
if($auth==0)//管理员
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
elseif($auth==1)//主管
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
elseif($auth==2)//大使
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
//权限写入session
$_SESSION['authority']=$authorityList;
//没有查询结果或者密码不正确
if(empty($re)||$hash_pwd!=$re[0]['pwd'])
{
    echo 'error';
}
else{
    echo 'ok';
}

