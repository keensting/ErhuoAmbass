<?php
/**二维数组排序
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/30
 * Time: 21:12
 */

class two_dimension_array_sort{
    static function execute($array,$key)
    {
        $key_array=array();
        foreach($array as $v)
        {
            $key_array[]=$v[$key];
        }

        array_multisort($key_array,SORT_DESC,$array);
        return $array;
    }
}

//$arr=array(
//    array(
//        'name'=>'sadas',
//        'age'=>12,
//    ),
//    array(
//        'name'=>'sadas',
//        'age'=>19,
//    ),
//    array(
//        'name'=>'sadas',
//        'age'=>11,
//    ),
//);
//
//two_dimension_array_sort::execute($arr,'age');
