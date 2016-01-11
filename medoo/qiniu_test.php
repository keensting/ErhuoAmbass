<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/27
 * Time: 16:31
 */
require('../qiniu/autoload.php');
//require('../qiniu/src/Qiniu/Auth.php');
header('Access-Control-Allow-Origin:*');
use \Qiniu\Auth;
$access_key='lhMwghBTBfeu54AKS3NHcHRxX8IZc90Kz-MFigBg';
$secret_key='DPCU0DvzVgO2DrqYGsfT1xqOumpTVvRm963x-pmR';

$auth=new Auth($access_key,$secret_key);
$bucket='erhuo-activity';
$upToken = $auth->uploadToken($bucket);

echo $upToken;
