<?php
/**调用该接口的文件一定要包含medoo、firstdb和maindb
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/28
 * Time: 19:23
 */

class b_value_calculator{
    protected $ekey;//大使的邀请码
    protected $begin;   //开始时间·
    protected $end;   //结束时间
    protected $local;//本地数据库
    protected $remote;//远端数据库

    //构造函数，初始化所有的变量
    function __construct($key,$begin,$end)
    {
        $this->ekey=$key;
        $this->begin=$begin;
        $this->end=$end;
        $this->local=new medoo();
        $this->remote=new maindb();

    }

    //静态方法，方便外部调用
    static function static_run($key,$begin=0,$end=9999999999)
    {
//        $local=new medoo();
        $remote=new maindb();
        $firstdb=new firstdb();
        $auth_list=$remote->select('p_user','uid',array(
            'AND'=>array(
                'invite'=>$key,
                'auth_time[>]'=>$begin,
                'auth_time[<]'=>$end,
                'auth'=>1,
            ),
        ));
        if(empty($auth_list))
        {
            return 0;//没有邀请认证，b值返回0
        }else{
            //根据每个uid去查询机器码
//            print_r($auth_list);
            $mc_list=array();
            $null_mc=0;
            foreach($auth_list as $v)
            {
                $re=$firstdb->select('auth','deviceid',array(
                   'uid'=>$v,
                ));
                if(empty($re[0]))
                {
                    $mc_list[$null_mc]='';
                    $null_mc+=1;
                }else{
                    $mc_list[$re[0]]='';
                }
//                $mc_list[]=$re[0];
            }
//            print_r($mc_list);
            $b_value=number_format(count($auth_list)/count($mc_list),2);//b_value保留两位小数
            return $b_value;
        }

    }


}