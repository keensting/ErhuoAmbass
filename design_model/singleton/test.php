<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/25
 * Time: 23:46
 */
require('single.php');

//exit;
$single=Single::getInstance();
$single->run();
//正确方法,用双冒号::操作符访问静态方法获取实例
//$danli = Danli::getInstance();
//$danli->test();
