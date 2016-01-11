<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/22
 * Time: 16:32
 */

require_once('../include/school_handler.php');
echo 'sadasd';

echo 'ok';
$list=school_handler::through_area_get_school('江西');
echo '66';
print_r($list);