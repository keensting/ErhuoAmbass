<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/3
 * Time: 17:33
 */

require('../../../medoo/medoo.php');
$arr1=explode('/',substr($_GET['start'],0,10));
$arr2=explode(':',substr($_GET['start'],11,19));
$begin=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
unset($arr1);
unset($arr2);
$arr1=explode('/',substr($_GET['end'],0,10));
$arr2=explode(':',substr($_GET['end'],11,19));
$end=gmmktime($arr2[0],$arr2[1],$arr2[2],$arr1[0],$arr1[1],$arr1[2]);
unset($arr1);
unset($arr2);
$local_db=new medoo();
$list=$local_db->select('salary','*',array(
    'AND'=>array(
        'id[!]'=>'',
        'time[>]'=>$begin,
        'time[<]'=>$end,
    )
));
$file_name='工资详单'.date('Y-m-d').'.csv';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file_name.'"');
//header('Cache-Control: max-age=0');


echo "编号,邀请码,结算时间,备注,金额,支出类型,是否发放\n";
foreach($list as $v)
{
    echo $v['id'].',';
    echo $v['ekey'].',';
    echo date('Y-m-d H:i:sa',$v['time']).',';
    echo $v['note'].',';
    echo $v['num'].',';
    if($v['type']==1)
    {
        echo '工资'.',';
    }elseif($v['type']==2)
    {
        echo '订单'.',';
    }elseif($v['type']==3)
    {
        echo '认证'.',';
    }
    if($v['is_give']==1)
    {
        echo '已发放',",\n";
    }elseif($v['is_give']==0)
    {
        echo '未发放',",\n";
    }

}


