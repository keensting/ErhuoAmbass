<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/13
 * Time: 20:31
 */
require_once('../include/check_server_position.php');
session_start();
session_destroy();
$demo=new position();
echo '<center><h1 style="color: chartreuse;">注销成功！</h1></center><meta http-equiv="refresh" content="2;url=http://am.erhuoapp.com/'.$demo->get_position().'/project/htdocs/index.php">';