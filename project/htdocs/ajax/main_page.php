<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/15
 * Time: 17:09
 */

require_once('../../../medoo/medoo.php');
require_once('../../../medoo/maindb.php');

$type=$_POST['type'];
$begin=($_POST['index']-1)*20;
$local=new medoo();
$remote=new maindb();

//管理员查全部的
if($type=='admin')
{
    $re=$local->select('ambassador','*',array(
        'auth[>]'=>0,
        'LIMIT'=>[$begin,20],

    ));
}elseif($type=='manager')//管理员查区域大使
{
    $province=$_POST['province'];
    $re=$local->select('ambassador','*',array(
        'AND'=>array(
            'province'=>$province,
            'auth'=>2,
        ),
        'LIMIT'=>[$begin,20],
    ));
}
//统一去远端数据库匹配数据
foreach($re as &$v)
{
    $reg=$remote->count('p_user','*',array(
        'invite'=>$v['ekey'],
    ));
    $aut=$remote->count('p_user','*',array(
        'AND'=>array(
            'invite'=>$v['ekey'],
            'auth'=>1,
        ),
    ));
    $orders=$local->count('orders','*',array(
        'ekey'=>$v['ekey'],
    ));
    $v['reg']=$reg;
    $v['aut']=$aut;
    $v['ord']=$orders;

}
unset($remote);
unset($local);

echo json_encode(array(
    'index'=>$_POST['index'],
    'list'=>$re,
));