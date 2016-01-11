<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/27
 * Time: 19:57
 */
require('../../../qiniu/autoload.php');
require('../../../medoo/medoo.php');
//use Qiniu\Auth;
require('../../include/check_server_position.php');
use Qiniu\Storage\UploadManager;

$token=$_POST['token'];
$local=new medoo();
$demo=new position();
$position=$demo->get_position();

$uploadMgr=new UploadManager();
//用来标记是否上传完成
$flag1=false;
$flag2=false;
$flag3=false;
//活动宣传图
if (($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/pjpeg"))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    }
    else
    {
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        echo "Type: " . $_FILES["file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];
        $file_path1=$_FILES['file']['tmp_name'];
        $file_name1=$_FILES['file']['name'];
        $flag1=true;
    }

}
else
{
    echo "Invalid file banner_img";
}


//上传规则图片
if (($_FILES["rule"]["type"] == "image/gif")
        || ($_FILES["rule"]["type"] == "image/jpeg")
        || ($_FILES["rule"]["type"] == "image/png")
        || ($_FILES["rule"]["type"] == "image/pjpeg"))
{
    if ($_FILES["rule"]["error"] > 0)
    {
        echo "Error: " . $_FILES["rule"]["error"] . "<br />";
    }
    else
    {
        echo "Upload: " . $_FILES["rule"]["name"] . "<br />";
        echo "Type: " . $_FILES["rule"]["type"] . "<br />";
        echo "Size: " . ($_FILES["rule"]["size"] / 1024) . " Kb<br />";
        echo "Stored in: " . $_FILES["rule"]["tmp_name"];
        $file_path2=$_FILES['rule']['tmp_name'];
        $file_name2=$_FILES['rule']['name'];
        $flag2=true;
    }

}
else
{
    echo "Invalid file rule";
}


//上传活动内容
if (($_FILES["content"]["type"] == "image/gif")
    || ($_FILES["content"]["type"] == "image/jpeg")
    || ($_FILES["content"]["type"] == "image/png")
    || ($_FILES["content"]["type"] == "image/pjpeg"))
{
    if ($_FILES["content"]["error"] > 0)
    {
        echo "Error: " . $_FILES["content"]["error"] . "<br />";
    }
    else
    {
        echo "Upload: " . $_FILES["content"]["name"] . "<br />";
        echo "Type: " . $_FILES["content"]["type"] . "<br />";
        echo "Size: " . ($_FILES["content"]["size"] / 1024) . " Kb<br />";
        echo "Stored in: " . $_FILES["content"]["tmp_name"];
        $file_path3=$_FILES['content']['tmp_name'];
        $file_name3=$_FILES['content']['name'];
        $flag3=true;
    }

}
else
{
    echo "Invalid file content";
}
//三个文件都上传完成才开始向七牛传输
if($flag1&&$flag2&&$flag3)
{

    date_default_timezone_set('PRC');

    $name=$_POST['name'];
    $theme=$_POST['theme'];
    $time_begin=$_POST['begin'];
    $time_end=$_POST['end'];
    $u_time=time();
    $state=$_POST['state'];
    if(empty($name)||empty($theme)||empty($time_begin)||empty($time_end))
    {//检查输入框
        echo '<center><h1 style="color: red">请填写完整的活动信息！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$position.'/project/htdocs/add_activity.php">';
        exit;
    }
    else{
        list($ret1, $err1) = $uploadMgr->putFile($token, $file_name1, $file_path1);
//        echo "\n====> putFile result: \n<br>";
//        if ($err1 !== null) {
//            var_dump($err);
//        } else {
//            var_dump($ret1);
//        }

        list($ret2, $err2) = $uploadMgr->putFile($token, $file_name2, $file_path2);
//        echo "\n====> putFile result: \n<br>";
//        if ($err2 !== null) {
//            var_dump($err2);
//        } else {
//            var_dump($ret2);
//        }

        list($ret3, $err3) = $uploadMgr->putFile($token, $file_name3, $file_path3);
//        echo "\n====> putFile result: \n<br>";
//        if ($err3 !== null) {
//            var_dump($err3);
//        } else {
//            var_dump($ret3);
//        }

        $id=$local->insert('activity',array(
            'name'=>$name,
            'theme'=>$theme,
            'time_begin'=>$time_begin,
            'time_end'=>$time_end,
            'content'=>$ret3['key'],
            'rule'=>$ret2['key'],
            'img'=>$ret1['key'],
            'u_time'=>$u_time,
            'state'=>$state,
        ));

        if(empty($id))
        {
            echo '<center><h1 style="color: red">添加失败，写入数据库出错！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$position.'/project/htdocs/add_activity.php">';

        }else{
            echo '<center><h1 style="color: greenyellow">活动添加成功！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$position.'/project/htdocs/add_activity.php">';

        }


    }



}
else{
    echo '<center><h1 style="color: red">添加活动失败，文件上传到云端出错！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$position.'/project/htdocs/add_activity.php">';

}


