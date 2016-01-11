<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/29
 * Time: 13:36
 */

require('erhuo.php');
require('../../medoo/medoo.php');

class salary_give_out extends erhuoSmarty
{
    protected function init()
    {
        $this->get_salary_list();
        $this->display('salary_give_out.tpl');
    }
    //获得目前需要结算的薪资列表
    protected function get_salary_list()
    {
        $total=0;
        $local=new medoo();
        $user_list=array();//需要发工资的大使的ekey列表
        $salary_list=array();
        //所有未结算列表
        $list=$local->select('salary',array(
            '[>]ambassador'=>'ekey'

        ),array(
            'ekey',
            'num',
            'ambassador.zfb_id',
            'ambassador.name',
        ),array(
            'is_give'=>0,
        ));

//        print_r($list);
        //检索出用户列表，拍重,统计总额
        foreach($list as $v)
        {
            $total+=$v['num'];
            $user_list[$v['ekey']]='';
        }
        //填充工资列表的工资总额
        foreach($user_list as $k=>$v)
        {
            $num=0;
            $name='';
            $zfb_id='';
            foreach($list as $l)
            {
                if($l['ekey']==$k)
                {
                    $num+=$l['num'];
                    $name=$l['name'];
                    $zfb_id=$l['zfb_id'];

                }
            }

            $salary_list[]=array(
                'name'=>$name,
                'ekey'=>$k,
                'num'=>$num,
                'zfb_id'=>$zfb_id,
            );
        }
        $this->assign('info',array(
            'total'=>$total,
            'person'=>count($user_list),
        ));
        $this->assign('salary_list',$salary_list);

    }

}

$demo=new salary_give_out();
$demo->run();