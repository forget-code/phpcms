<?php
require './include/common.inc.php';
require_once MOD_ROOT.'/admin/include/useramount.class.php';
$useramount = new useramount();

$condition = array();
$title = '汇款记录';
$condition[] = "userid = '$_userid' " ;
$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$pagesize;
$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$amounts = $useramount->get_list($condition, $page, $pagesize);
$pages = $amounts['pages'];
include template( 'pay', 'useramount_view');
?>