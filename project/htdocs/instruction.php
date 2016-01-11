<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/21
 * Time: 11:41
 */

require_once('./erhuo.php');
class instruction extends erhuoSmarty{
    protected function init()
    {
        $this->display('instruction.tpl');
    }
}
$demo=new instruction();
$demo->run();