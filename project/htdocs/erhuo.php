<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/12
 * Time: 22:30
 */
require_once('../../Smarty/Smarty.class.php');
require_once('../include/check_server_position.php');

class erhuoSmarty extends Smarty{
    protected $tplPath;
    protected $filePath='../project/';//引用css或者js文件的通用路径
    protected $cssList=array();
    protected $jsList=array();
    protected $authorityList=array();//权限标记
    protected function init()
    {

        //子类复写
    }
    function __construct(){
        $this->template_dir = '../../templates/';
        $this->compile_dir = '../../templates_c/';
        $this->config_dir = '../../configs/';
        $this->cache_dir ='../../cache';
        $this->caching='false';
        $this->left_delimiter='{';
        $this->right_delimiter='}';
    }





    protected  function check_login_state()
    {
        $pos=new position();
        $type=$pos->get_position();
        if(empty($_SESSION['userinfo']))
        {
            echo '<center><h1 style="color: chartreuse;">请登录！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$type.'/project/htdocs/index.php">';
            exit;
        }

    }
//    protected function  addCSS()
//    {
//        //todo
//        $this->cssList[]= '../bootstrap/css/bootstrap.min.css';//引用了bootstrap的样式文件
//        $this->assign('css',$this->cssList);
//        //动态添加css文件
//    }
//    protected  function addJS()
//    {
//        //todo
//        $this->jsList[]='../bootstrap/js/bootstrap.min.js';
//        $this->assign('js',$this->jsList);
//        //动态加载js文件
//    }
    protected function outputHead()
    {
        //todo
        //输出标准头
        $this->assign('header','true');
        $this->assign('userinfo',array(
            'name'=>$_SESSION['userinfo']['name'],
            'auth'=>$_SESSION['userinfo']['auth'],
        ));
    }
//    protected function outputFoot()
//    {
//        //todo
//        //输出标准尾
//    }
    public function run()
    {
        session_start();
        $this->check_login_state();
        $this->outputHead();
        $this->init();
    }

}

//$demo=new erhuoSmarty();
//$demo->run();
//$demo->assign('test','hello');
//
//$demo->display('index.tpl');