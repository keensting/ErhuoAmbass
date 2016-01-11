<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/26
 * Time: 11:36
 */
require('./erhuo.php');

class deal_authority extends erhuoSmarty{
    protected function init()
    {
        $this->display('deal_authority.tpl');
    }
}
$demo=new deal_authority();
$demo->run();
