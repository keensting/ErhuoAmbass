<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/25
 * Time: 19:00
 */
require('erhuo.php');
class manager_page extends erhuoSmarty
{
    protected function init()
    {
        //只有管理员可以访问该页面
        $this->check_identity();
        $this->display('manager_page.tpl');
    }

    protected function check_identity()
    {
        if($_SESSION['userinfo']['auth']>0||empty($_SESSION))
        {
            echo '您没有足够的权限访问此页面！';
            exit;
        }
    }
}
$demo=new manager_page();
$demo->run();