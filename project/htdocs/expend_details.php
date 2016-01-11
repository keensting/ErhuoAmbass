<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/3
 * Time: 16:54
 */
require('erhuo.php');

class expend_details extends erhuoSmarty{

    protected function init()
    {
        $this->display('expend_details.tpl');
    }
}
$demo=new expend_details();
$demo->run();