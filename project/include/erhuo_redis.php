<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/22
 * Time: 14:41
 */

class erhuo_redis extends Redis{

    function __construct()
    {
        $this->connect('127.0.0.1', 6379);
    }

}