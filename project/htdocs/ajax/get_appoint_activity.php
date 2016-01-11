<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/30
 * Time: 22:19
 */

require('../../../medoo/medoo.php');

$id=$_POST['id'];
$local_db=new medoo();
$re=$local_db->select('activity','*',array('id'=>$id));
echo json_encode($re[0]);