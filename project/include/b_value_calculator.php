<?php
/**���øýӿڵ��ļ�һ��Ҫ����medoo��firstdb��maindb
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/28
 * Time: 19:23
 */

class b_value_calculator{
    protected $ekey;//��ʹ��������
    protected $begin;   //��ʼʱ�䡤
    protected $end;   //����ʱ��
    protected $local;//�������ݿ�
    protected $remote;//Զ�����ݿ�

    //���캯������ʼ�����еı���
    function __construct($key,$begin,$end)
    {
        $this->ekey=$key;
        $this->begin=$begin;
        $this->end=$end;
        $this->local=new medoo();
        $this->remote=new maindb();

    }

    //��̬�����������ⲿ����
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
            return 0;//û��������֤��bֵ����0
        }else{
            //����ÿ��uidȥ��ѯ������
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
            $b_value=number_format(count($auth_list)/count($mc_list),2);//b_value������λС��
            return $b_value;
        }

    }


}