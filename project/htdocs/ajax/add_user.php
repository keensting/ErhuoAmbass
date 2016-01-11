<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/13
 * Time: 17:23
 */

require_once('../../../medoo/medoo.php');
require_once('../../include/check_server_position.php');
session_start();
$db=new medoo();
$rand=$_POST['randdata'];
$pwd=$_POST['pwd'];
$hash_pwd=sha1($rand.$pwd);
$pos=new position();
$type=$pos->get_position();
//$db->query('set names utf-8');
if($_SESSION['authority']['add_user']) {//权限检查
    if(empty($_POST['nickname'])||empty($_POST['key'])||empty($_POST['name'])||empty($_POST['province'])||empty($_POST['date'])||empty($_POST['randdata']))
    {
        echo '<h1 style="color: red">信息填充不完整！</h1><meta http-equiv="refresh" content="2;url=http://ambassador.erhuoapp.com/'.$type.'/project/htdocs/adduser.php">';
        exit;
    }
    try {
        if($_POST['auth']==0)
        {
            $level=21;
        }
        elseif($_POST['auth']==1)
        {
            $level=11;
        }else{
            $level=0;
        }

        //时间格式转化
        $arr=explode('/',substr($_POST['date'],0,10));
        $date=gmmktime(0,0,0,$arr[0],$arr[1],$arr[2]);
//        print_r($date);
        $id=$db->insert('ambassador',
            array(
                'nickname' => $_POST['nickname'],
                'ekey' => $_POST['key'],
                'pwd' => $hash_pwd,
                'auth' => $_POST['auth'],
                'date' => $date,
                'school' => $_POST['school'],
                'province' => $_POST['province'],
                'city' => $_POST['city'],
                'randdata' => $_POST['randdata'],
                'name'=>$_POST['name'],
                'level'=>$level,
                'salary'=>0,
            ));
        //信息和school表进行匹配更新
        $school=$db->select('school','*',array(
            'name'=>$_POST['school'],
        ));
        if(empty($school))
        {
            $db->insert('school',array(
                'name'=>$_POST['school'],
                'area'=>$_POST['province'],
                'city'=>$_POST['city'],
            ));
        }else{
            $db->update('school',array(
                'area'=>$_POST['province'],
                'city'=>$_POST['city'],
            ),array(
                'name'=>$_POST['school'],
            ));
        }
        unset($db);
    } catch (Exception $e) {
        echo '<center><h1 style="color: red">添加失败！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$type.'/project/htdocs/adduser.php">';
    }

    if($id>0) {
        echo '<center><h1 style="color: chartreuse;">添加成功！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/' . $type . '/project/htdocs/adduser.php">';
    }else
    {
        echo $id;
//        echo '<h1 style="color: red">添加失败！</h1><meta http-equiv="refresh" content="2;url=http://ambassador.erhuoapp.com/'.$type.'/project/htdocs/adduser.php">';
    }
}
else{
    echo '<center><h1 style="color: red">权限不足！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$type.'/project/htdocs/adduser.php">';
}

