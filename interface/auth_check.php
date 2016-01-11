<?php
/**通过手机号检查用户的验证状态（大使邀请码：240010）
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/30
 * Time: 10:24
 */

require('../medoo/maindb.php');
require('../Mail/email.class.php');

class interface_auth_check{
    protected $phone;//需要验证的手机号
    protected static $key=240010;//需要验证的大使邀请
    protected $local_db;//本地数据库
    protected $time_begin;//数据筛选开始时间
    protected $time_end;//数据筛选结束时间
    protected $partner_id;//淘点金
    protected $partner_key;//淘点金
    protected $target_url;//淘点金post地址
    protected $return_message;//淘点金返回的正确信息
    protected $file_stream;//日志文件流
    protected $mail_content=array();//错误邮件内容！
    protected $flag=false;//flag==true的时候表示推送出现问题，会推送邮件到我的邮箱！

    //构造函数，初始化相关的信息
    function __construct()
    {
        date_default_timezone_set('PRC');
        $this->partner_id='11';
        $this->partner_key='fc1de9a8e88bed0b71ad93103720f144';
        $this->target_url='http://partner.xnl2015.com/app/phone';
        $this->file_stream=fopen('./log/auth_check_log.log','a') or die('Log File Open Failed!');
        $this->return_message='success';
    }
    //析构函数，关闭文件流
    function __destruct()
    {
        $this->write_log_file("----Log End\n");
        fclose($this->file_stream);
    }
    protected function write_log_file($text)
    {
        fwrite($this->file_stream,$text);
    }
    //根据第三方的key生成指定的md5签名串
    protected function generate_sign($phone)
    {
        $str='partner_id='.$this->partner_id.'&user_phone='.$phone.$this->partner_key;
        return md5($str);
    }
    //获得本次执行脚本的时间周期
    protected function get_time_range()
    {
        $this->time_begin=time()-60*30;//半小时的时间间隔
        $this->time_end=time();
        $this->write_log_file("#######################DiVIDER######################\n");
        $this->write_log_file("Time:".date('Y/m/d h:i:sa',$this->time_begin)."\n");
        $this->write_log_file("Range:30minus\n----Log Begin\n");
    }
    //检索符合要求的数据
    protected  function check_data()
    {
        $list=array();
        $this->local_db=new maindb();
        $arr=$this->local_db->select('p_user','*',array(
            'AND'=>array(
                'invite'=>self::$key,
                'auth'=>1,
                'authed_time[>=]'=>$this->time_begin,
                'authed_time[<]'=>$this->time_end,
            ),
            'ORDER'=>'auth_time DESC',
        ));
        if(empty($arr))
        {
            return $list;
        }
        foreach($arr as $v)
        {
            $list[]=$v['phone'];
        }
        return $list;

    }
    //执行所有推送操作
    protected function execute_operation()
    {
        $list=$this->check_data();
        if(empty($list))
        {
            $this->write_log_file('No one authorised in this period!'."\n");
        }else {
            foreach($list as $v) {
                $data = array(
                    'partner_id' => $this->partner_id,
                    'user_phone' => $v,
                    'sign' => $this->generate_sign($v),
                );
                $re = $this->sent_post_data($this->target_url, $data);
                if ($re == $this->return_message) {
                    $this->write_log_file($v.'----OK' . "\n");
                }else{
                    $this->flag=true;
                    $this->write_log_file($v.'----FAILED' . "\n");
                    $this->mail_content[]=$v.'---FAILED';
                }

                sleep(4);//延迟4秒发送post请求
            }
        }

    }
    //模拟post请求
    protected function sent_post_data($url, $data=array()){//file_get_content
        $postdata = http_build_query(
            $data
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    //邮件接口
    protected function sent_mail()
    {
        //******************** 配置信息 ********************************
        date_default_timezone_set('PRC');
        $smtpserver = "smtp.qq.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "707719848@qq.com";//SMTP服务器的用户邮箱
        $smtpemailto = 'keensting@163.com';//发送给谁
        $smtpuser = "707719848";//SMTP服务器的用户帐号
        $smtppass = "lx19950712jiao";//SMTP服务器的用户密码
        $mailtitle = '淘点金认证用户推送失败！';//邮件主题
        $mailcontent = "<h1>推送时间：".date('Y-m-d h:i:sa')."</h1><br>";//邮件内容
        foreach($this->mail_content as $v)
        {
            $mailcontent.=$v.'<br>';
        }
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
        //************************ 配置信息 ****************************
        $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false;//是否显示发送的调试信息
        $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
//        $smtp->sendmail('502599073@qq.com', $smtpusermail, $mailtitle, $mailcontent, $mailtype);//给石头发一份
//        if($state=='')
//        {
//            echo 'failed';
//        }
    }
    //启动命令
    function run()
    {
        $this->get_time_range();
        $this->execute_operation();
        if($this->flag)//出错的时候发送报告！
        {
            $this->sent_mail();
        }
    }
}
$demo=new interface_auth_check();
$demo->run();
