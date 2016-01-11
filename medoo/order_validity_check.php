<?php
/**每月10号的23点50执行，填充未结算订单的状态
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/27
 * Time: 13:25
 */
require('medoo.php');
require('maindb.php');
require('../Mail/email.class.php');
class check_handler{
    protected $local;
    protected $remote;
    protected $mail_content=array();

    function __construct()
    {
        $this->local=new medoo();
        $this->remote=new maindb();
    }

    function run()
    {
        $this->deal_data();
        $this->mail_notice();
    }

    protected function deal_data()
    {
        $list=$this->local->select('orders','*',array('state'=>0));//列出所有没有结算的订单
        foreach($list as $v)
        {
            $re=$this->remote->select('p_order','*',array('id'=>$v['order_id']));
            if($re[0]['state']==4&&$re[0]['did']>0)//退款订单标记为已经支付，订单状态标记为退款订单-1
            {
//                $this->local->delete('orders',array('order_id'=>$v['order_id']));
                $this->local->update('orders',array('order_state'=>-1,'state'=>1),array('order_id'=>$v['order_id']));
                $this->mail_content[]=$v['ekey'].'的订单（'.$v['order_id'].'）因退款而被关闭！';
            }elseif($re[0]['state']==4&&$re[0]['did']==0)//顺利完成的订单,order_state改为4
            {
                $this->local->update('orders',array('order_state'=>4),array('order_id'=>$v['order_id']));
                $this->mail_content[]=$v['ekey'].'的订单（'.$v['order_id'].'）通过审核！';
            }
            else{//否则，将订单状态直接写入数据库
                $this->local->update('orders',array('order_state'=>$re[0]['state']),array('order_id'=>$v['order_id']));
                $this->mail_content[]=$v['ekey'].'的订单（'.$v['order_id'].'）未完成！';
            }
        }
    }

    function mail_notice()
    {
        //******************** 配置信息 ********************************
        $smtpserver = "smtp.qq.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "707719848@qq.com";//SMTP服务器的用户邮箱
        $smtpemailto = 'keensting0712@163.com';//发送给谁
        $smtpuser = "707719848";//SMTP服务器的用户帐号
        $smtppass = "lx19950712jiao";//SMTP服务器的用户密码
        $mailtitle = '订单数据审核完毕！';//邮件主题
        $mailcontent='';
        foreach($this->mail_content as $v)
        {
            $mailcontent.=$v.'<br>';
        }
        date_default_timezone_set('PRC');
        $mailcontent .= "<h1>更新时间：".date('Y-m-d h:i:sa')."</h1>";//邮件内容
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
$demo=new check_handler();
$demo->run();

