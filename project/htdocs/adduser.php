<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/13
 * Time: 16:35
 */
require_once('erhuo.php');

class add_user extends erhuoSmarty{



//    protected function addCSS()
//    {
//        $this->cssList[]=$this->filePath.'style/erhuoDS.css';
//        parent::addCSS();
//    }

    protected function init()
    {
        session_start();
        $this->assign('session',$_SESSION);
//        $this->assign('userinfo',array(
//            'name'=>$_SESSION['userinfo']['name'],
//        ));
        $this->display('adduser.tpl');
//        $this->assign('test','hello1111');
//        $this->display('test.tpl');

    }




}


$demo=new add_user();

$demo->run();