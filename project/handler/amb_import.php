<?php
/**大使数据导入
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/20
 * Time: 11:53
 */

require_once('../include/csv_analysis.php');
require_once('../../medoo/medoo.php');
$demo=new csv_analysis('../assert/ambassador.csv');
$list=$demo->run();
//print_r($list);
$db=new medoo();

foreach($list as $v)
{
    $re=$db->insert('ambassador',array(
        'province'=>$v[0],
        'school'=>$v[1],
        'name'=>$v[2],
        'nickname'=>$v[3],
        'ekey'=>$v[4],
        'randdata'=>'su5HZkbKXo',
        'pwd'=>sha1('su5HZkbKXo'.md5('22222222')),
        'auth'=>$v[6],
        'city'=>'',
        'date'=>time(),
        'level'=>0,
        'salary'=>0,
    ));
    echo 'id='.$re."\n";
}

echo '数据导入已完成！';

