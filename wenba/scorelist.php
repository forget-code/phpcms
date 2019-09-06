<?php 
require_once './include/common.inc.php';
$option = empty($option) ? 'all' : trim($option);

include template('wenba','scorelist');
?>