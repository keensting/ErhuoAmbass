<?php
/**导入学校信息
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/20
 * Time: 14:27
 */
require_once('../../medoo/medoo.php');

$file=fopen('../assert/school.txt','r')or die('文件打开失败！');
$db=new medoo();
while($v=fgets($file))
{
    $v=str_replace('"','',$v);
    $re=$db->query($v);
    print_r($v);
}

