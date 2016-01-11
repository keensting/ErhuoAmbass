<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/16
 * Time: 11:50
 */

class position{
    protected $url;


    function get_position()
    {
        $this->url=$_SERVER['SCRIPT_NAME'];
        preg_match('/test/',$this->url,$re1);
        if($re1[0]=='test')//测试服务器
        {
            return 'test';
        }
        preg_match('/online/',$this->url,$re2);
        if($re2[0]=='online')//线上服务器
        {
            return 'online';
        }
        else{
            return 'error';
        }
    }
}
