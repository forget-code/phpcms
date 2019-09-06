<?php
require './include/common.inc.php';
require_once MOD_ROOT.'/admin/include/useramount.class.php';
$useramount = new useramount();

$condition = array();
$title = '汇款记录';
$condition[] = "userid = '$_userid' " ;
$page = isset($page) ? intval($page) : 1;
$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$offset = ($page-1)*$pagesize;
$amounts = $useramount->get_list($condition, $page, $pagesize);
$pages = $amounts['pages'];
include template( 'pay', 'useramount_view');
?>