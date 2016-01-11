<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/12
 * Time: 23:36
 */
$key=$_POST['key'];
$begin=$_POST['begin'];
//echo 'dasd';
//$key='泷泽萝拉';
$url='http://image.haosou.com/j?q='.urlencode($key).'&src=srp&sn='.$begin.'&pn=10';


$myfile=fopen($url,'r')or die('failed');

$data=fgets($myfile);

fclose($myfile);

$list=json_decode($data,true);
$arr=array();
foreach ($list['list'] as $v) {
    $arr[]=array(
        'title'=>$v['title'],
        'img'=>$v['img'],
        'url'=>$v['link'],
    );

}
unset($list);

//print_r($arr);
echo json_encode($arr);