<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/22
 * Time: 18:47
 */

require_once('./maindb.php');
require('../Mail/email.class.php');
require_once('../project/include/erhuo_redis.php');

class import_area_data
{
    protected $_redis;
    protected $_area_list=array(//省，直辖市，自治区
        '安徽','澳门','北京','福建','甘肃',
        '广东','广西','贵州','海南','河北',
        '河南','黑龙江','湖北','湖南','吉林',
        '江苏','江西','辽宁','内蒙古','宁夏',
        '青海','山东','山西','陕西','上海',
        '四川','台湾','天津','西藏','香港',
        '新疆','云南','浙江','重庆',
    );
    function __construct()
    {
        $this->_redis=new erhuo_redis();
    }

    protected function get_area_data()
    {
        foreach($this->_area_list as $v)
        {
            $arr=$this->_redis->lRange($v,0,500);
            $reg=0;
            $reg_in=0;
            $auth=0;
            $auth_in=0;
            //获得认证总数
            $remote=new maindb();
            foreach($arr as $row)
            {
                $num1=$remote->count('p_user','*',array(
                        'school'=>$row,
                ));
                $reg+=$num1;
                $num2=$remote->count('p_user','*',array(
                    'AND'=>array(
                        'school'=>$row,
                        'invite[!]'=>'',
                    ),
                ));
                $reg_in+=$num2;
                $num3=$remote->count('p_user','*',array(
                    'AND'=>array(
                        'school'=>$row,
                        'auth'=>1,
                    ),
                ));
                $auth+=$num3;

                $num4=$remote->count('p_user','*',array(
                    'AND'=>array(
                        'school'=>$row,
                        'auth'=>1,
                        'invite[!]'=>'',
                    ),
                ));
                $auth_in+=$num4;
            }
            $result=array(
                'register_all' => $reg,
                'authority_all' => $auth,
                'register_invite' => $reg_in,
                'authority_invite' => $auth_in,
                'register_nature' => ($reg - $reg_in),
                'authority_nature' => ($auth - $auth_in),
            );
            $this->_redis->hMset('_'.$v,$result);
            echo $v.'成功！';

        }

//        $this->_redis->hMset('_安徽',array(
//            'name'=>'keensting',
//            'age'=>23,
//            'school'=>'wwwww',
//        ));
//
//        $list=$this->_redis->hGetAll('_安徽');
//        print_r($list);
    }

    function run()
    {
        date_default_timezone_set('PRC');
        $this->get_area_data();
        $this->mail_notice();
    }

    function get_demo_data($area)
    {
        $list=$this->_redis->hGetAll('_'.$area);
        print_r($list);
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
        $mailtitle = '地区统计数据更新完毕！';//邮件主题
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
$demo=new import_area_data();
$demo->run();
//$demo->get_demo_data('河北');