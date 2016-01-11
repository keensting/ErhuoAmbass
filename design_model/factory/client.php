<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/26
 * Time: 11:53
 */
require(dirname(__FILE__).'/factory.php');


$factory=new human_factory();
$human=$factory->create_human('black');
$human->color();
$human->talk();