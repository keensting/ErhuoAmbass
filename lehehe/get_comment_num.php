<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/24
 * Time: 19:56
 */

require('medoo.php');

$db=new lhh_db();
$id=$_POST['id'];
$re=$db->count('dbd_comment','*',array(
    'dbd_id'=>$id
));
echo $re;