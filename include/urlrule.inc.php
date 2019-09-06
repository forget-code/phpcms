<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$urlrule['html']['cat'][0] = array('example'=>'/it/product/list_2.html','index'=>'{$parentdir}{$catdir}/{$index}.{$fileext}', 'page'=>'{$parentdir}{$catdir}/{$prefix}{$catid}_{$page}.{$fileext}');
$urlrule['html']['cat'][1] = array('example'=>'/html/list_2_1.html','index'=>'/{$htmldir}/{$prefix}{$catid}.{$fileext}', 'page'=>'/{$htmldir}/{$prefix}{$catid}_{$page}.{$fileext}');
$urlrule['html']['cat'][2] = array('example'=>'/list_2_1.html','index'=>'/{$prefix}{$catid}.{$fileext}', 'page'=>'/{$prefix}{$catid}_{$page}.{$fileext}');

$urlrule['html']['item'][0] = array('example'=>'/2006/1010/article_1_2.html','index'=>'/{$year}/{$month}{$day}/{$prefix}{$itemid}.{$fileext}', 'page'=>'/{$year}/{$month}{$day}/{$prefix}{$itemid}_{$page}.{$fileext}');
$urlrule['html']['item'][1] = array('example'=>'/it/product/2006/1010/article_1_2.html','index'=>'{$parentdir}{$catdir}/{$year}{$month}/{$prefix}{$itemid}.{$fileext}', 'page'=>'{$parentdir}{$catdir}/{$year}{$month}/{$prefix}{$itemid}_{$page}.{$fileext}');
$urlrule['html']['item'][2] = array('example'=>'/html/article_1_2.html','index'=>'/{$htmldir}/{$prefix}{$itemid}.{$fileext}', 'page'=>'/{$htmldir}/{$prefix}{$itemid}_{$page}.{$fileext}');
$urlrule['html']['item'][3] = array('example'=>'/article_1_2.html','index'=>'/{$prefix}{$itemid}.{$fileext}', 'page'=>'/{$prefix}{$itemid}_{$page}.{$fileext}');

$urlrule['html']['special'][0] = array('example'=>'/special/200610/special_1_2.html','index'=>'/special/{$index}.{$fileext}', 'list'=>'/special/list_{$page}.{$fileext}', 'show'=>'/special/{$year}{$month}/{$prefix}{$specialid}.{$fileext}');
$urlrule['html']['special'][1] = array('example'=>'/special/2006/special_1_2.html','index'=>'/special/{$index}.{$fileext}', 'list'=>'/special/list_{$page}.{$fileext}', 'show'=>'/special/{$year}/{$prefix}{$specialid}.{$fileext}');
$urlrule['html']['special'][2] = array('example'=>'/special/special_1_2.html','index'=>'/special/{$index}.{$fileext}', 'list'=>'/special/list_{$page}.{$fileext}', 'show'=>'/special/{$prefix}{$specialid}.{$fileext}');


$urlrule['php']['cat'][0] = array('example'=>'/list.php?catid=1&page=2','index'=>'/list.php?catid={$catid}', 'page'=>'/list.php?catid={$catid}&page={$page}');
$urlrule['php']['cat'][1] = array('example'=>'/list.php?catid-1/page-2.html','index'=>'/list.php?catid-{$catid}.html', 'page'=>'/list.php?catid-{$catid}/page-{$page}.html');
$urlrule['php']['cat'][2] = array('example'=>'/list-1-2.html','index'=>'/list-{$catid}-1.html', 'page'=>'/list-{$catid}-{$page}.html');

$urlrule['php']['item'][0] = array('example'=>'/show.php?itemid=1&page=2','index'=>'/show.php?itemid={$itemid}', 'page'=>'/show.php?itemid={$itemid}&page={$page}');
$urlrule['php']['item'][1] = array('example'=>'/show.php?itemid-1/page-2.html','index'=>'/show.php?itemid-{$itemid}.html', 'page'=>'/show.php?itemid-{$itemid}/page-{$page}.html');
$urlrule['php']['item'][2] = array('example'=>'/show-1-2.html','index'=>'/show-{$itemid}-1.html', 'page'=>'/show-{$itemid}-{$page}.html');

$urlrule['php']['special'][0] = array('example'=>'/special/show.php?specialid=1&typeid=2','index'=>'/special/index.php', 'list'=>'/special/list.php?page={$page}', 'show'=>'/special/show.php?specialid={$specialid}', 'type'=>'/special/show.php?specialid={$specialid}&typeid={$typeid}');
$urlrule['php']['special'][1] = array('example'=>'/special/show.php?specialid-1/typeid-2.html','index'=>'/special/index.php', 'list'=>'/special/list.php?page-{$page}.html', 'show'=>'/special/show.php?specialid-{$specialid}.html', 'type'=>'/special/show.php?specialid-{$specialid}/typeid-{$typeid}.html');
$urlrule['php']['special'][2] = array('example'=>'/special/show-1-2.html','index'=>'/special/index.php', 'list'=>'/special/list-{$page}.html', 'show'=>'/special/show-{$specialid}.html', 'type'=>'/special/show-{$specialid}-{$typeid}.html');

$urlrule['php']['area'][0] = array('example'=>'/area.php?areaid=1&page=2','index'=>'/area.php?areaid={$areaid}', 'page'=>'/area.php?areaid={$areaid}&page={$page}');
$urlrule['php']['area'][1] = array('example'=>'/area.php?areaid-1/page-2.html','index'=>'/area.php?areaid-{$areaid}.html', 'page'=>'/area.php?areaid-{$areaid}/page-{$page}.html');
$urlrule['php']['area'][2] = array('example'=>'/area-1-2.html','index'=>'/area-{$areaid}-1.html', 'page'=>'/area-{$areaid}-{$page}.html');
?>