<?php
/**每月11号执行，审核大使业绩，进行相应的升降处理以及工资发放！
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/24
 * Time: 19:29
 */
require('./medoo.php');
require('./maindb.php');
require('../Mail/email.class.php');

class level_check{
    protected $local_db;//本地数据库
    protected $remote_db;//远端数据库
    protected $ambassador_list;//大使列表
    //各个段位大使的任务目标
    protected $mission_target=array(
        '0'=>array(
            'auth'=>0,
            'order'=>0,
        ),
        '1'=>array(
            'auth'=>30,
            'order'=>30,
        ),
        '2'=>array(
            'auth'=>50,
            'order'=>60,
        ),
        '3'=>array(
            'auth'=>80,
            'order'=>90,
        ),
    );
    //大使晋升注册数达标线
    protected $level_line=array(
        '0'=>0,
        '1'=>200,
        '2'=>500,
        '3'=>800,
    );
    //大使工资标准
    protected $salary_list=array(
        '0'=>0,'1'=>200,'2'=>350,'3'=>550,
    );
    //邮件记录详情
    protected $mail_content=array();
    //构造函数
    function __construct()
    {
        //实例化本地数据库和远端数据库
        $this->local_db=new medoo();
        $this->remote_db=new maindb();
    }
    //运行函数
    function run()
    {
        date_default_timezone_set('PRC');
        $this->get_ambassador_list();
        $this->check_performance();
        print_r($this->mail_content);
        $this->sent_mail();

    }
    //发送邮件
    protected function sent_mail()
    {
        //******************** 配置信息 ********************************
        $smtpserver = "smtp.qq.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "707719848@qq.com";//SMTP服务器的用户邮箱
        $smtpemailto = 'keensting0712@163.com';//发送给谁
        $smtpuser = "707719848";//SMTP服务器的用户帐号
        $smtppass = "lx19950712jiao";//SMTP服务器的用户密码
        $mailtitle = '上月大使业绩审核完毕！';//邮件主题
        $mailcontent = "<h1>审核完成时间：".date('Y-m-d h:i:sa')."</h1><br>";//邮件内容
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
    //获得所有大使信息到大使列表中
    function get_ambassador_list()
    {
        //mark标示大使的状态，-1为之前降过的，0是没动过的，1是之前晋升过的
        $this->ambassador_list=$this->local_db->select('ambassador',array(
            'ekey','mark','level','name'
        ),array(
            'auth'=>2,//只对大使进行自动晋级结算操作
        ));
    }

    //挨个处理每个大使
    function check_performance()
    {
        foreach($this->ambassador_list as $v)
        {
//            print_r($v);
            $level=$v['level'];
            $mark=$v['mark'];
            $key=$v['ekey'];
            $name=$v['name'];
            //获得当月1号时间
            $now=time()-10*24*60*60;
            //获得上个月1号的时间戳
            $past=$this->get_pre_month_time(date('m'));
//            print_r($now);
//            echo '---';
//            print_r($past);
//            echo '---';


            //审核订单数和认证数是否合格
            $order_num=$this->local_db->count('orders',array(
                'AND'=>array(
                    'ekey'=>$key,
                    'u_time[>]'=>$past,
                    'order_state'=>4,//完结，没有发生退款的订单
                    'u_time[<]'=>$now,
                ),
            ));
//            print_r($order_num);echo '---';
            $auth_num=$this->remote_db->count('p_user',array(
                'AND'=>array(
                    'invite'=>$key,
                    'auth_time[>]'=>$past,
                    'auth_time[<]'=>$now,
                    'auth'=>1,
                ),
            ));
//            print_r($auth_num);echo '---';
            //大使的升降&工资发放处理
            if($mark==-1)//上个月有降级
            {
                //之前降级的，1.2倍任务量检测
                if($order_num>=($this->mission_target[$level+1]['order'])*1.2 && $auth_num>=($this->mission_target[$level+1]['auth'])*1.2)//通过
                {
                    //升级，发放之前等级的工资
                    $this->level_deal($key,true);
//                    $this->salary_deal($key,$this->salary_list[$level],$level);
                    $this->mail_content[]=$name.'完成指标，再次晋升为'.($level+1).'星大使！(认证：'.$auth_num.',订单：'.$order_num.')';
                }else if($order_num>=$this->mission_target[$level]['order']&&$auth_num>=$this->mission_target[$level]['auth']){
                    //达到当前段位标准只发放工资
//                    $this->salary_deal($key,$this->salary_list[$level],$level);
                    $this->mail_content[]=$name.'完成指标！(认证：'.$auth_num.',订单：'.$order_num.')';
                }
                else{
                    $this->level_deal($key,false);
                    $this->mail_content[]=$name.'未完成指标，再次降级为'.($level-1).'星大使！(认证：'.$auth_num.',订单：'.$order_num.')';
                }

            }
            else{//没有被降级过
                if($order_num>=$this->mission_target[$level]['order']&&$auth_num>=$this->mission_target[$level]['auth']){
                    //达到当前段位标准只发放工资
//                    $this->salary_deal($key,$this->salary_list[$level],$level);
                    $this->mail_content[]=$name.'完成指标！(认证：'.$auth_num.',订单：'.$order_num.')';
                }
                else{
                    $this->level_deal($key,false);
                    $this->mail_content[]=$name.'未完成指标，被降级为'.($level-1).'星大使！(认证：'.$auth_num.',订单：'.$order_num.')';
                    $mark=-1;
                }
            }
            //未降职的大使，认证达标自动升级
            $auth_all=$this->get_ambassador_auth_number($key);
//            print_r($auth_all);echo '---';
            if($auth_all>$this->level_line[$level+1] && $mark!=-1)
            {
                $this->level_deal($key,true);
                $this->mail_content[]=$name.'认证数完成指标，自动升级为'.($level-1).'星大使';
            }


        }
    }

    //获取单个大使的总认证数
    function get_ambassador_auth_number($key)
    {
        $num=$this->remote_db->count('p_user','*',array(
            'AND'=>array(
                'invite'=>$key,
                'auth'=>1,
            ),
        ));
        return $num;
    }
    //发工资&&写入工资表
//    function salary_deal($key,$salary,$level)
//    {
//        //增加大事表中的salary
//        $this->local_db->update('ambassador',array(
//            'salary[+]'=>$salary,
//        ),array(
//            'ekey'=>$key,
//        ));
//        //在salary记录这一条支出
//        $this->local_db->insert('salary',array(
//            'ekey'=>$key,
//            'time'=>time(),
//            'note'=>'大使每月工资',
//            'num'=>$this->salary_list[$level],
//            'type'=>1,//工资
//            'is_give'=>0,
//        ));
//
//
//    }

    //升级降级操作
    function level_deal($key,$promote=true)
    {
        if($promote)//升级
        {
            $this->local_db->update('ambassador',array(
                'level[+]'=>1,
                'mark'=>1,
            ),array(
                'ekey'=>$key,
            ));
        }else{//降级
            $re=$this->local_db->update('ambassador',array(
                'level[-]'=>1,
                'mark'=>-1,
            ),array(
                'ekey'=>$key,
            ));
            echo $re;
        }
    }

    //获得 前一个月1号的时间戳 ,参数为本月的月份
    function  get_pre_month_time($month)
    {
        if($month==1)
        {//跨年
            $time_stamp=gmmktime(0,0,0,12,1,date('Y')-1);
        }
        else{//年内结算
            $time_stamp=gmmktime(0,0,0,$month-1,1,date('Y'));
        }
        return $time_stamp;
    }
}

$demo=new level_check();
$demo->run();