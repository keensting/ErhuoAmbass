<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/20
 * Time: 16:36
 */
require('medoo.php');
require('maindb.php');
require('firstdb.php');
require('../project/include/b_value_calculator.php');



class get_yesterday_b_value_list
{
    protected  $list;
    protected $local_db;
    protected $remote_db;
    protected $time_begin;
    protected $time_end;

    function __construct()
    {

        $this->local_db=new medoo();
        $this->remote_db=new maindb();
    }
    protected function output_header()
    {
        date_default_timezone_set('PRC');
        $filename=date('Y/m/d',strtotime("yesterday"));
        $arr=explode('/',$filename);
        $this->time_begin=mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
        $this->time_end=mktime(23,59,59,$arr[1],$arr[2],$arr[0]);
//        print_r($this->time_begin);
//        print_r($this->time_end);
        header("Content-Type: application/vnd.ms-excel; charset=GBK");
        header("Pragma: public");header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=".$filename."大使B值统计.csv ");
        header("Content-Transfer-Encoding: binary ");
    }

    protected function get_ambass_list()
    {
        $this->local_db->query('SET NAMES GBK');
        $this->list=$this->local_db->select('ambassador',array(
            'name','ekey','province','school'
        ));

        foreach($this->list as &$v)
        {
            $v['b_value']=b_value_calculator::static_run($v['ekey'],$this->time_begin,$this->time_end);
            $v['reg']=$this->remote_db->count('p_user','*',array(
                'AND'=>array(
                    'invite'=>$v['ekey'],
                    'reg_time[>]'=>$this->time_begin,
                    'reg_time[<]'=>$this->time_end,
                )
            ));
            $v['auth']=$this->remote_db->count('p_user','*',array(
                'AND'=>array(
                    'auth'=>1,
                    'invite'=>$v['ekey'],
                    'auth_time[>]'=>$this->time_begin,
                    'auth_time[<]'=>$this->time_end,
                )
            ));

        }

    }

    protected function generator_csv_file()
    {
        foreach($this->list as $v)
        {
            echo $v['name'].',';
            echo $v['ekey'].',';
            echo $v['province'].',';
            echo $v['school'].',';
            echo 'B值：,';
            echo $v['b_value'].",\n";
            echo ',,,,注册:,'.$v['reg'].",\n";
            echo ',,,,认证:,'.$v['auth'].",\n";
        }
    }



    function run()
    {
        $this->output_header();
        $this->get_ambass_list();
        $this->generator_csv_file();

    }

}

$demo=new get_yesterday_b_value_list();
$demo->run();



