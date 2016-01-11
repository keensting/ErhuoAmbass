<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/23
 * Time: 16:21
 */
require('./erhuo.php');
require('../../medoo/medoo.php');
require('../include/two_dimension_array_sort.php');
class a_boards extends erhuoSmarty
{

    protected function init()
    {
        $this->get_activity_list();
        $this->display('activity_boards.tpl');
    }

    //获取有效的活动列表
    protected function get_activity_list()
    {
        $local_db=new medoo();
        $list=$local_db->select('activity','*',array('state'=>1));
        $list=two_dimension_array_sort::execute($list,'id');
        $this->assign('act_list',$list);

    }

}
$demo=new a_boards();
$demo->run();