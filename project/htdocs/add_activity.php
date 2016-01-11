<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/27
 * Time: 17:49
 */
require('erhuo.php');

class demo_handler extends erhuoSmarty{

    protected function init()
    {
        $this->display('add_activity.tpl');
    }
}
$demo=new demo_handler();
$demo->run();