<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/24
 * Time: 12:07
 */
echo 'asdasd';
require('Mail/mail.php');//����mail.php����
echo '1';
$params = array('host' => 'smtp.exmail.qq.com',
    'port' => '465',
    'username' => 'lx@erhuoapp.com',
    'password' => 'rx*bmcxjxegb8!f',
    'auth' => true);//���뱣֤��һ��

$recipients = '13126734215@163.com'; //�����ˣ�������һ����������Ŷ����ַ
echo '2';
$headers['From']    = "lx@erhuoapp.com";
$headers['To']      = "13126734215@163.com";
$headers['Subject'] = "��ʱ���񱨸�";
echo '13';
$body = "hello";
//ѡ��smtp�ķ��ͷ�ʽ����Ȼ��֧��mail()��sendmail
$mail_object = &Mail::factory('smtp', $params);
if (PEAR::isError($e = $mail_object->send($recipients, $headers, $body))) {
  die($e->getMessage() . "\n");
}else
{
    echo 'ok';
}