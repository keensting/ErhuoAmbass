<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/19
 * Time: 15:16
 */
require_once('erhuo.php');
require_once('../../medoo/medoo.php');
require_once('../../medoo/maindb.php');
//接收传值
class order_details extends erhuoSmarty
{
    protected $key;
    protected $state=array(
        '0'=>'无效订单',
        '1'=>'等待买家付款',
        '2'=>'等待卖家发货',
        '3'=>'卖家已经发货',
        '4'=>'买家已经收货',
        '-1'=>'退款订单',
    );
    protected function init()
    {
        $this->key=$_GET['key'];//获得大使的key
        $this->get_order_list();
        $this->display('order_details.tpl');

    }

    protected function get_order_list()
    {
        $local=new medoo();
        $remote=new maindb();
        $list=$local->select('orders','*',array(
            'ekey'=>$this->key,
        ));
        if(!empty($list))
        {
            foreach($list as &$v)
            {
                $info=$remote->select('p_order','*',array(
                    'id'=>$v['order_id'],
                ));
                //将unix时间戳转化为日期
                $v['u_time']=date('Y-m-d H:i:s',$v['u_time']);
                $v['c_time']=date('Y-m-d H:i:s',$v['c_time']);
                if($info[0]['did']>0)
                {
                    $v['order_state']=$this->state['-1'];
                }else{
                    $v['order_state']=$this->state[$info[0]['state']];
                }

            }
        }
        $this->assign('list',$list);

    }
}
$demo=new order_details();
$demo->run();