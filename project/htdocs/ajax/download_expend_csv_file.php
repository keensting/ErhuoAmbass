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
$file_name='�����굥'.date('Y-m-d').'.csv';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file_name.'"');
//header('Cache-Control: max-age=0');


echo "���,������,����ʱ��,��ע,���,֧������,�Ƿ񷢷�\n";
foreach($list as $v)
{
    echo $v['id'].',';
    echo $v['ekey'].',';
    echo date('Y-m-d H:i:sa',$v['time']).',';
    echo $v['note'].',';
    echo $v['num'].',';
    if($v['type']==1)
    {
        echo '����'.',';
    }elseif($v['type']==2)
    {
        echo '����'.',';
    }elseif($v['type']==3)
    {
        echo '��֤'.',';
    }
    if($v['is_give']==1)
    {
        echo '�ѷ���',",\n";
    }elseif($v['is_give']==0)
    {
        echo 'δ����',",\n";
    }

}


