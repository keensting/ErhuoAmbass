<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/2
 * Time: 11:04
 */
require('erhuo.php');

class change_activity_state extends erhuoSmarty{

    protected function init()
    {
        $this->display('change_activity_state.tpl');
    }

}
$demo=new change_activity_state();
$demo->run();
