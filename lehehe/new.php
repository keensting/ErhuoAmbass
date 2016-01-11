<?php
/**
 * Created by PhpStorm.
 * User: keensting
 * Date: 15-11-16
 * Time: 下午5:50
 */
require('../qiniu/autoload.php');
require('medoo.php');
header('Access-Control-Allow-Origin:*');
use \Qiniu\Auth;
use Qiniu\Storage\UploadManager;


class lhh_new{

    protected function init()
    {

        $auth=$_POST['auth'];
        $type=$_POST['type'];
        $append=$_POST['append'];

        if($type==2)
        {
//            $content=$this->upload_to_qiniu();
            $content=$_POST['media'];
        }elseif($type==1)
        {
            $content=$_POST['text'];
        }

//        print_r($content);
        if(empty($auth))
            $auth='小贰乐呵呵';
        if(empty($content))
        {echo '内容不能为空！';exit;}



        $this->insert_into_database($auth,$type,$append,$content);

    }

    protected function insert_into_database($auth,$type,$append,$content)
    {
        $local_db=new lhh_db();
//        print_r($local_db);

        date_default_timezone_set('PRC');
        $re=$local_db->insert('lhh_list',array(
            'header'=>'http://7xnquu.com1.z0.glb.clouddn.com/app_icon.png',
            'auth'=>$auth,
            'type'=>$type,
            'append'=>$append,
            'content'=>$content,
            'time'=>time(),
            'up'=>0,
            'down'=>0,
            'comment'=>0,
        ));
        if(!empty($re))
        {
            echo '上传成功！';
        }else{
            echo '上传失败！';
        }

    }


    protected function get_qiniu_uptoken()
    {
        $access_key='lhMwghBTBfeu54AKS3NHcHRxX8IZc90Kz-MFigBg';
        $secret_key='DPCU0DvzVgO2DrqYGsfT1xqOumpTVvRm963x-pmR';

        $auth=new Auth($access_key,$secret_key);
        $bucket='erhuo-activity';
        $upToken = $auth->uploadToken($bucket);

        return $upToken;
    }

    protected function upload_to_qiniu()
    {
//        if (($_FILES["file"]["type"] == "image/gif")
//            || ($_FILES["file"]["type"] == "image/jpeg")
//            || ($_FILES["file"]["type"] == "image/png")
//            || ($_FILES["file"]["type"] == "image/pjpeg"))
//        {
            if ($_FILES["media"]["error"] > 0)
            {
                echo "Error: " . $_FILES["media"]["error"] . "<br />";
            }
            else
            {
//                echo "Upload: " . $_FILES["media"]["name"] . "<br />";
//                echo "Type: " . $_FILES["media"]["type"] . "<br />";
//                echo "Size: " . ($_FILES["media"]["size"] / 1024) . " Kb<br />";
//                echo "Stored in: " . $_FILES["media"]["tmp_name"];
                $file_path1=$_FILES['media']['tmp_name'];
                $file_name1=$_FILES['media']['name'];
            }

//        }
        $uploadMgr=new UploadManager();
        $token=$this->get_qiniu_uptoken();
        list($ret1, $err1) = $uploadMgr->putFile($token, $file_name1, $file_path1);

        return $ret1['key'];
    }

    function run()
    {
        $this->init();
    }
}
$demo=new lhh_new();
$demo->run();