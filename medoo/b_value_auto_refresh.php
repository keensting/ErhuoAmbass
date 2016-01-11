<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/28
 * Time: 20:24
 */
require('./medoo.php');
require('./maindb.php');
require('./firstdb.php');
require('../project/include/b_value_calculator.php');
require('../Mail/email.class.php');


class demo_handler_b_value_cal{
    protected $local_db;
    protected $remote_db;
    protected $ambassador_list;
    protected $ekey_b_list=array();
    protected $mail_content=array();

    function __construct()
    {
        $this->local_db=new medoo();
        $this->remote_db=new maindb();
    }

    function run()
    {
        $this->get_ambass_list();
        $this->cal_b_value();
        $this->update_ambass_b_value();
        $this->sent_mail();
    }

    protected function get_ambass_list()
    {
        $this->ambassador_list=$this->local_db->select('ambassador','ekey',array(
            'id[>]'=>0
        ));
//        print_r($this->ambassador_list);
    }


    protected function cal_b_value()
    {
        foreach($this->ambassador_list as $v)
        {
            $b_value=b_value_calculator::static_run($v);
//            print_r($b_value);
            $this->ekey_b_list[]=array(
                'ekey'=>$v,
                'b_value'=>$b_value,
            );

        }
//        print_r($this->ekey_b_list);
    }

    protected function update_ambass_b_value()
    {
        foreach($this->ekey_b_list as $v)
        {
            if(empty($v['b_value']))
            {
                $this->mail_content[]=$v['ekey'].'B值依旧为0！';
                continue;
            }
            else{
                $re=$this->local_db->update('ambassador',array('b_value'=>$v['b_value']),array('ekey'=>$v['ekey']));
                if($re==1)
                {
                    $this->mail_content[]=$v['ekey'].'更新成功，B值更新为'.$v['b_value'];
                }else{
                    $this->mail_content[]=$v['ekey'].'B值没有更新！';
                }

            }
        }
    }

    protected function sent_mail()
    {
        //******************** 配置信息 ********************************
        date_default_timezone_set('PRC');
        $smtpserver = "smtp.qq.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "707719848@qq.com";//SMTP服务器的用户邮箱
        $smtpemailto = 'keensting0712@163.com';//发送给谁
        $smtpuser = "707719848";//SMTP服务器的用户帐号
        $smtppass = "lx19950712jiao";//SMTP服务器的用户密码
        $mailtitle = '今日大使B值更新完毕！';//邮件主题
        $mailcontent = "<h1>更新完成时间：".date('Y-m-d h:i:sa')."</h1><br>";//邮件内容
        foreach($this->mail_content as $v)
        {
            $mailcontent.=$v.'<br>';
        }
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
        //************************ 配置信息 ****************************
        $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false;//是否显示发送的调试信息
        $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
        $smtp->sendmail('502599073@qq.com', $smtpusermail, $mailtitle, $mailcontent, $mailtype);//给石头发一份
        if($state=='')
        {
            echo 'failed';
        }
    }


}
$demo=new demo_handler_b_value_cal();
$demo->run();

//
//$value=b_value_calculator::static_run('210034');
//
//print_r($value);






