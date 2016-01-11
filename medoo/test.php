<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/24
 * Time: 0:57
 */
require('./maindb.php');
//require('./firstdb.php');
//$db=new firstdb();
$db=new maindb();
$re=$db->select('p_user','*',array('nickname'=>$_GET['name']));
//$re=$db->select('auth','*');
print_r($re);