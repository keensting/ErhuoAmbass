<?php
/**测试B值
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/9
 * Time: 11:46
 */
//require('./medoo.php');
//require('./maindb.php');
//require('./firstdb.php');
//require('../project/include/b_value_calculator.php');
//
//$a=b_value_calculator::static_run('230230');
//echo $a;


class test001{
    public function sent_post_data($url, $data=array()){//file_get_content
        $postdata = http_build_query(
            $data
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}
$demo=new test001();
$re=$demo->sent_post_data('http://www.erhuoapp.com/api/2.2.4/picked_goods_list',array('activity_id'=>1,'lati'=>0,'longi'=>0,'index'=>0,'number'=>10));
//echo json_encode($re);
print_r($re);

//echo addslashes($re);
