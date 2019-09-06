<?php 
require './include/common.inc.php';
require_once MOD_ROOT.'include/special.class.php';
$special = new special();
$specialid = 5;
$page = intval($page);
$page = max(1,$page);
$data = $special->video_ajax_pages($specialid, $page, 10);

include template('video','special_ajax');
?>