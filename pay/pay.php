<?php
require './include/common.inc.php';
require_once MOD_ROOT.'/include/exchange.class.php';
$exchange = new exchange();
$condition = array();
if(empty($type)) $condition[] = " `type` = 'amount'" ; else $condition[] = " `type` = '$type'";
if(!empty($module)) $condition['module']  = '$module' ;
$page = isset($page) ? intval($page) : 1;
$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$exchanges = $exchange->get_list( $condition, $page, $pagesize);
$pages = $exchanges['pages'];
include template('pay', 'exchange_view');
?>