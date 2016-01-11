<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/12
 * Time: 19:56
 */
require_once('../Smarty/Smarty.class.php');

class EHSmarty extends Smarty{
    protected $tplPath;
    protected $filePath='../project/';//引用css或者js文件的通用路径
    protected $cssList=array();
    protected $jsList=array();
    protected function init()
    {

        //子类复写
    }
    function EHSmarty()
    {
        $this->template_dir = '../templates/';
        $this->compile_dir = '../templates_c/';
        $this->config_dir = '../configs/';
        $this->cache_dir ='../cache';
        $this->caching='false';
        $this->left_delimiter='{';
        $this->right_delimiter='}';
    }
    protected  function checkValidity()
    {
        //todo
        //检测登录用户的合法性
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
//    protected function outputHead()
//    {
//        //todo
//        //输出标准头
//    }
//    protected function outputFoot()
//    {
//        //todo
//        //输出标准尾
//    }
    public function run()
    {
        $this->checkValidity();
        $this->init();
    }

}
