<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/25
 * Time: 11:20
 */
require('medoo.php');
require('maindb.php');

class fetch_all_invite_auth_data{
    protected $local_db;
    protected $remote_db;
    protected $am_list=array();
    protected $auth_list=array();

    function __construct()
    {
        $this->local_db=new medoo();
        $this->local_db->query('SET NAMES GBK');
        $this->remote_db=new maindb();
        $this->remote_db->query('SET NAMES GBK');
        header("Content-Type: application/vnd.ms-excel; charset=GBK");
        header("Pragma: public");header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=邀请注册数据.csv ");
        header("Content-Transfer-Encoding: binary ");
    }

    function run()
    {
        $this->init();
    }

    function get_ambassador_list()
    {

        $re=$this->local_db->select('ambassador',array(
            'ekey','name','school'
        ));
        foreach($re as $v)
        {
            $this->am_list[$v['ekey']]=$v;//大使的邀请俺作为key
        }

    }

    function get_all_invite_auth()
    {
        $this->auth_list=$this->remote_db->select('p_user',array(
            'uid','nickname','invite','school','auth_time'
        ),array(
            'AND'=>array(
                'invite[!]'=>'',
                'auth'=>1,
            ),
        ));
    }

    function export_csv_file()
    {
        echo '邀请码,大使姓名,大使所在学校,用户昵称,用户ID,用户所在学校,认证时间,'."\n";
        foreach($this->auth_list as $v)
        {
            echo $v['invite'].',';
            if(empty($this->am_list[$v['invite']]))
            {
                echo ',,';
            }else
            {
                echo $this->am_list[$v['invite']]['name'].',';
                echo $this->am_list[$v['invite']]['school'].',';
            }
            echo $v['nickname'].',';
            echo $v['uid'].',';
            echo $v['school'].',';
            echo date('Y/m/d h:i:sa',$v['auth_time'])."\n";
        }

    }

    protected function init()
    {
        date_default_timezone_set('PRC');
        $this->get_ambassador_list();
        $this->get_all_invite_auth();
        $this->export_csv_file();

    }
}
$demo=new fetch_all_invite_auth_data();
$demo->run();
