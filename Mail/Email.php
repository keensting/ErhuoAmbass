<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/24
 * Time: 12:07
 */
echo 'asdasd';
require('Mail/mail.php');//包含mail.php函数
echo '1';
$params = array('host' => 'smtp.exmail.qq.com',
    'port' => '465',
    'username' => 'lx@erhuoapp.com',
    'password' => 'rx*bmcxjxegb8!f',
    'auth' => true);//必须保证这一行

$recipients = '13126734215@163.com'; //接收人，可以是一个数组来存放多个地址
echo '2';
$headers['From']    = "lx@erhuoapp.com";
$headers['To']      = "13126734215@163.com";
$headers['Subject'] = "定时任务报告";
echo '13';
$body = "hello";
//选择smtp的发送方式，当然还支持mail()和sendmail
$mail_object = &Mail::factory('smtp', $params);
if (PEAR::isError($e = $mail_object->send($recipients, $headers, $body))) {
  die($e->getMessage() . "\n");
}else
{
    echo 'ok';
}