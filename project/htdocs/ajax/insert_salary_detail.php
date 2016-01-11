<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/26
 * Time: 19:43
 */
require('../../../medoo/medoo.php');
//require('../../../medoo/maindb.php');

class salary_insert{
    protected $local;
//    protected $remote;
    protected $type;
    function __construct()
    {
        date_default_timezone_set('PRC');
        $this->local=new medoo();
//        $this->remote=new maindb();
        $this->type=$_POST['type'];
    }

    protected function operation()
    {
        //认证的薪资结算
        if($this->type=='auth')
        {
            $note=$_POST['note'];
            $key=$_POST['key'];
            $d_salary=$_POST['d_salary'];
            $extra=$_POST['extra'];
            $num=$extra+$d_salary;

            if($num==0)//工资为0，不写入数据表
            {
                echo 'ok';
                exit;
            }
            //获得大使的b_value,给工资打折扣
            $b_value=$this->local->select('ambassador','b_value',array('ekey'=>$key));
            $num=number_format($num/$b_value[0],2,'.','');
//            echo $num;
            $re=$this->local->insert('salary',array(
                'ekey'=>$key,
                'time'=>time(),
                'note'=>$note,
                'num'=>$num,
                'type'=>3,//认证
                'is_give'=>0,//默认没有发放
            ));


            if($re>0)
            {

                echo 'ok';
            }else{
                echo 'error';
            }
        }elseif($this->type=='order')
        {
            //订单的薪资结算
            $arr1=explode('/',substr($_POST['begin'],0,10));
            $arr2=explode(':',substr($_POST['begin'],11,19));
            $begin=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
            unset($arr1);
            unset($arr2);
            $arr1=explode('/',substr($_POST['end'],0,10));
            $arr2=explode(':',substr($_POST['end'],11,19));
            $end=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
            unset($arr1);
            unset($arr2);
            $act_id=$_POST['act_id'];
            $key=$_POST['key'];
            $num=$_POST['d_salary']+$_POST['extra'];
            $note=$_POST['note'].',activity_id='.$act_id;
            if($num==0)
            {
                echo 'ok';
                exit;
            }
            $re=$this->local->insert('salary',array(
                'ekey'=>$key,
                'time'=>time(),
                'note'=>$note,
                'num'=>$num,
                'type'=>2,//订单
                'is_give'=>0,
            ));
//            //给大使加上工资
//            $re1=$this->local->update('ambassador',array(
//                'salary[+]'=>$num,
//            ),array(
//                'ekey'=>$key,
//            ));
//            if(empty($re)||$re1!=1)
//            {
//                echo 'error';
//                exit;
//            }

            //按照大使的ekey和时间段改变这段时间内特定订单的状态
            $counter=$this->local->update('orders',array(
                    'state'=>1,
            ),array(
                    'AND'=>array(
                        'ekey'=>$key,
                        'u_time[>]'=>$begin,
                        'u_time[<]'=>$end,
                        'act_id'=>$act_id,
                    ),
                )

            );
            if($counter==$_POST['d_salary'])//改动条数正常
            {
                echo 'ok';
            }else{
                echo 'fetal';
            }




        }
    }

    function run()
    {
        $this->operation();
    }
}

$demo=new salary_insert();
$demo->run();