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
    protected $filePath='../project/';//����css����js�ļ���ͨ��·��
    protected $cssList=array();
    protected $jsList=array();
    protected function init()
    {

        //���ิд
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
        //����¼�û��ĺϷ���
    }
//    protected function  addCSS()
//    {
//        //todo
//        $this->cssList[]= '../bootstrap/css/bootstrap.min.css';//������bootstrap����ʽ�ļ�
//        $this->assign('css',$this->cssList);
//        //��̬���css�ļ�
//    }
//    protected  function addJS()
//    {
//        //todo
//        $this->jsList[]='../bootstrap/js/bootstrap.min.js';
//        $this->assign('js',$this->jsList);
//        //��̬����js�ļ�
//    }
//    protected function outputHead()
//    {
//        //todo
//        //�����׼ͷ
//    }
//    protected function outputFoot()
//    {
//        //todo
//        //�����׼β
//    }
    public function run()
    {
        $this->checkValidity();
        $this->init();
    }

}
