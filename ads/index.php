<?php
require './include/common.inc.php';
$page = $page ? intval($page) : 1;
$pagesize = $M['pagesize'] ? intval($M['pagesize']) : 12;
$count = $db->get_one("SELECT COUNT(*)  AS num FROM ".DB_PRE."ads_place WHERE passed=1");
$mumber = $count['num'];
$pages = pages($mumber, $page, $pagesize);
$offset = ($page-1)*$pagesize;
$places = $adses = array();
$places= $place->manage('WHERE passed=1', 1);
include template($mod, 'index');
?>