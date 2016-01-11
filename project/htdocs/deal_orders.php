<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/27
 * Time: 10:47
 */
require('../../medoo/medoo.php');
require('../../medoo/maindb.php');
require('erhuo.php');

class deal_orders extends erhuoSmarty
{
    //执行函数
    function init()
    {
        $this->get_activity_list();
        $this->display('deal_orders.tpl');
    }
    //获得所有在线活动的列表
    protected function get_activity_list()
    {
        $local=new medoo();
        $list=$local->select('activity',array(
            'id','name'
        ),array(
            'state'=>1,
        ));
        $this->assign('act_list',$list);
    }
}

$demo=new deal_orders();
$demo->run();