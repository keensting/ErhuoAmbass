<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/25
 * Time: 11:20
 */
require('medoo.php');
require('maindb.php');

class fetch_all_nature_auth_data{
    protected $local_db;
    protected $remote_db;
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
        header("Content-Disposition: attachment;filename=自然注册数据.csv ");
        header("Content-Transfer-Encoding: binary ");
    }

    function run()
    {
        $this->init();
    }


    function get_all_invite_auth()
    {
        $this->auth_list=$this->remote_db->select('p_user',array(
            'uid','nickname','school','auth_time'
        ),array(
            'AND'=>array(
                'invite'=>'',
                'auth'=>1,
            ),
        ));
    }

    function export_csv_file()
    {
        echo '用户昵称,用户ID,用户所在学校,认证时间,'."\n";
        foreach($this->auth_list as $v)
        {

            echo $v['nickname'].',';
            echo $v['uid'].',';
            echo $v['school'].',';
            echo date('Y/m/d h:i:sa',$v['auth_time'])."\n";
        }

    }

    protected function init()
    {
        date_default_timezone_set('PRC');
        $this->get_all_invite_auth();
        $this->export_csv_file();

    }
}
$demo=new fetch_all_nature_auth_data();
$demo->run();
