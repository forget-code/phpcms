<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$urlrule['html']['cat'][0] = array('example'=>'/mobile/nokia/list_2.html','index'=>'{$parentdir}{$catdir}/{$index}.{$fileext}', 'page'=>'{$parentdir}{$catdir}/{$prefix}{$catid}_{$page}.{$fileext}');
$urlrule['html']['cat'][1] = array('example'=>'/htmldir/list_2_1.html','index'=>'/{$htmldir}/{$prefix}{$catid}.{$fileext}', 'page'=>'/{$htmldir}/{$prefix}{$catid}_{$page}.{$fileext}');
$urlrule['html']['cat'][2] = array('example'=>'/list_2_1.html','index'=>'/{$prefix}{$catid}.{$fileext}', 'page'=>'/{$prefix}{$catid}_{$page}.{$fileext}');

$urlrule['html']['item'][0] = array('example'=>'/2006/1010/product_1.html','index'=>'/{$year}/{$month}{$day}/{$prefix}{$itemid}.{$fileext}');
$urlrule['html']['item'][1] = array('example'=>'/mobile/nokia/2006/1010/product_1.html','index'=>'{$parentdir}{$catdir}/{$year}{$month}/{$prefix}{$itemid}.{$fileext}');
$urlrule['html']['item'][2] = array('example'=>'/htmldir/product_1.html','index'=>'/{$htmldir}/{$prefix}{$itemid}.{$fileext}');
$urlrule['html']['item'][3] = array('example'=>'/product_1.html','index'=>'/{$prefix}{$itemid}.{$fileext}');

$urlrule['php']['cat'][0] = array('example'=>'/list.php?catid=1&page=2','index'=>'/list.php?catid={$catid}', 'page'=>'/list.php?catid={$catid}&page={$page}');
$urlrule['php']['cat'][1] = array('example'=>'/list.php?catid-1/page-2.html','index'=>'/list.php?catid-{$catid}.html', 'page'=>'/list.php?catid-{$catid}/page-{$page}.html');
$urlrule['php']['cat'][2] = array('example'=>'/list-1-2.html','index'=>'/list-{$catid}-1.html', 'page'=>'/list-{$catid}-{$page}.html');

$urlrule['php']['item'][0] = array('example'=>'/show.php?productid=1','index'=>'/show.php?productid={$itemid}');
$urlrule['php']['item'][1] = array('example'=>'/show.php?productid-1.html','index'=>'/show.php?productid-{$itemid}.html');
$urlrule['php']['item'][2] = array('example'=>'/show-1.html','index'=>'/show-{$itemid}.html');

?>