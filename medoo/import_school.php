<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/20
 * Time: 20:16
 */
require_once('./medoo.php');
require('../Mail/email.class.php');
require_once('../project/include/erhuo_redis.php');

class Redis_area_school_list{
    protected $_local;//本地数据库
    protected $_redis;//redis实例
    protected $_area_list=array(//省，直辖市，自治区
        '安徽','澳门','北京','福建','甘肃',
        '广东','广西','贵州','海南','河北',
        '河南','黑龙江','湖北','湖南','吉林',
        '江苏','江西','辽宁','内蒙古','宁夏',
        '青海','山东','山西','陕西','上海',
        '四川','台湾','天津','西藏','香港',
        '新疆','云南','浙江','重庆',
    );
    //构造函数
    function __construct(){
        $this->_local=new medoo();
        $this->_redis=new erhuo_redis();
    }
    //启动函数
    function run()
    {
//        echo 'ok!';
        date_default_timezone_set('PRC');
        $this->write_into_memory();
        $this->mail_notice();
//        echo 'here!';
    }
    //以省为key将学校过滤出来，写入memory
    protected function write_into_memory()
    {
        foreach($this->_area_list as $v)
        {
            $re=$this->_local->select('school','name',array('area'=>$v));
            if(empty($re))
            {
                echo $v."异常！\n";
            }else
            {
                foreach($re as $k=>$v1) {
                   $this->_redis->lPush($v,$v1);
                }
                echo $v.'导入成功！';
            }
        }
    }

    //发送邮件提醒
    function mail_notice()
    {
        //******************** 配置信息 ********************************
        $smtpserver = "smtp.qq.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "707719848@qq.com";//SMTP服务器的用户邮箱
        $smtpemailto = 'keensting0712@163.com';//发送给谁
        $smtpuser = "707719848";//SMTP服务器的用户帐号
        $smtppass = "lx19950712jiao";//SMTP服务器的用户密码
        $mailtitle = '学校数据更新完毕！';//邮件主题
        $mailcontent = "<h1>更新时间：".date('Y-m-d h:i:sa')."</h1>";//邮件内容
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
        //************************ 配置信息 ****************************
        $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false;//是否显示发送的调试信息
        $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
        if($state=='')
        {
            echo 'failed';
        }
    }

}
$demo=new Redis_area_school_list();
$demo->run();


//$redis=new erhuo_redis();
//$list=$redis->lRange('浙江',0,500);
//print_r($list);



//$demo=new maindb();
////echo 'ok';
////$re=$demo->select('p_user','*',array('nickname'=>'静淡雅然'));
////print_r($re);
//$redis = new Redis();
//print_r($redis);
//print_r(empty($redis));
//$redis->connect('127.0.0.1', 6379);
//echo "Connection to server sucessfully\n";
////check whether server is running or not
//echo "Server is running: ".$redis->ping()."\n";
////$redis->lPush('安徽',array('合肥工业大学','池州学院','巢湖学院'));
////$redis->lPush('安徽','安徽工业大学');
////$redis->lPush('安徽','安徽理工大学');
////$redis->lPush('安徽','安徽农业大学');
//
////$redis->expire('anhui',30);
//$list=$redis->lRange('安徽',0,500);
////$test=$redis->lPop('安徽');
////print_r($test);
//print_r($list);