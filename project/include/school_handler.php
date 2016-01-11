<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/20
 * Time: 23:53
 */
//require_once('../../medoo/medoo.php');
//require_once('../../medoo/maindb.php');

class school_handler{

    /**通过省份查找旗下所有的学校
     * @param $area 省市
     * @return array|bool $list 学校集合
     */
    static function through_area_get_school($area){

        $redis=new Redis();
        $redis->connect('127.0.0.1',6379);
        $list=$redis->lRange($area,0,500);
        if(empty($list)) {
            $local = new medoo();
            $list = $local->select('school', 'name', array('area' => $area));
            unset($local);
        }
        unset($redis);
        return $list;
    }


    static function manager_area_data_load($area,$start=0,$end=9999999999)
    {
        $result=array();
        if($start==0&&$end==9999999999) {
            //缓存中寻找数据
            try {
                $redis = new Redis();
            }catch (Exception $e)
            {
                echo $e->getMessage();
            }
            $redis->connect('127.0.0.1', 6379);
            $result = $redis->hGetAll('_' . $area);
        }
        //缓存中没有，去数据库查找
        if(empty($result)) {
            $list = self::through_area_get_school($area);
            $reg = 0;
            $reg_in = 0;
            $auth = 0;
            $auth_in = 0;
            //获得认证总数
            $remote = new maindb();
            foreach ($list as $v) {
                $num1 = $remote->count('p_user', '*', array(
                    'AND' => array(
                        'school' => $v,
                        'reg_time[>]' => $start,
                        'reg_time[<]' => $end,
                    ),
                ));
                $reg += $num1;
                $num2 = $remote->count('p_user', '*', array(
                    'AND' => array(
                        'school' => $v,
                        'reg_time[>]' => $start,
                        'reg_time[<]' => $end,
                        'invite[!]' => '',
                    ),
                ));
                $reg_in += $num2;
                $num3 = $remote->count('p_user', '*', array(
                    'AND' => array(
                        'school' => $v,
                        'auth_time[>]' => $start,
                        'auth'=>1,
                        'auth_time[<]' => $end,
                    ),
                ));
                $auth += $num3;

                $num4 = $remote->count('p_user', '*', array(
                    'AND' => array(
                        'school' => $v,
                        'auth_time[>]' => $start,
                        'auth'=>1,
                        'auth_time[<]' => $end,
                        'invite[!]' => '',
                    ),
                ));
                $auth_in += $num4;
            }

            $result = array(
                'register_all' => $reg,
                'authority_all' => $auth,
                'register_invite' => $reg_in,
                'authority_invite' => $auth_in,
                'register_nature' => ($reg - $reg_in),
                'authority_nature' => ($auth - $auth_in),
            );
        }

        unset($redis);
        return $result;




    }
}