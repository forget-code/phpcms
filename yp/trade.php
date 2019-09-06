<?php 
require './include/common.inc.php';
$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
$tradeid = intval($tradeid);
$tradeid or showmessage($LANG['illegal_parameters'],$PHP_SITEURL);
require_once PHPCMS_ROOT.'/include/tree.class.php';
$tree = new tree;
$AREA = cache_read('areas_'.$mod.'.php');
require_once PHPCMS_ROOT.'/include/area.func.php';
$TRADE = cache_read('trades_trade.php');
require_once MOD_ROOT.'/include/trade.func.php';
$ARE = cache_read('trade_'.$tradeid.'.php');
@extract($ARE);
$tradepos = tradepos($tradeid, ' &gt;&gt; ');
if($child==1)
{
	$arrchild = subtrade($mod, $tradeid);
	$templateid = $templateid ? $templateid : 'trade_list' ;
}
else
{	
	$page = isset($page) ? intval($page) : 1;
	$templateid = $listtemplateid ? $listtemplateid : 'trade_list';
}
include template($mod,$templateid);
?>