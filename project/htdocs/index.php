<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/12
 * Time: 21:44
 */
require_once('erhuo.php');

class login_page extends erhuoSmarty{



//    protected function addCSS()
//    {
//        $this->cssList[]=$this->filePath.'style/erhuoDS.css';
//        parent::addCSS();
//    }
    protected  function outputHead()
    {
        $this->assign('header','false');
        $this->assign('userinfo',array());
    }

    protected function init()
    {

        $this->display('index.tpl');
//        $this->assign('test','hello1111');
//        $this->display('test.tpl');

    }
    protected function check_login_state()
    {
        //µÇÂ¼Ò³²»¼Ì³ĞÅĞ¶Ïº¯Êı
    }




}


$demo=new login_page();

$demo->run();



