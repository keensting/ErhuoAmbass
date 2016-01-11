<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/24
 * Time: 20:47
 */

require('medoo.php');

$id=$_POST['id'];
session_start();
if(empty($_SESSION['user_info'])||empty($_POST))
{
    echo 'error';
    exit;
}

$db=new lhh_db();
$num=$db->count('dbd_record','*',array(
    'AND'=>array(
        'comment_id'=>$id,
        'uid'=>$_SESSION['user_info']['uid'],
    )
));

if(empty($num))
{
    $db->update('dbd_comment',array('up[+]'=>1),array('id'=>$id));
    $db->insert('dbd_record',array(
        'comment_id'=>$id,
        'uid'=>$_SESSION['user_info']['uid']
    ));
    echo 'ok';
}else
{
    echo 'repeat';
}
