<?php 
defined('IN_PHPCMS') or exit('Access Denied');
//房产信息
$urlrule['html']['type'][0] = array('example'=>'/rent/rent_1.html','index'=>'/{$typedir}/{$index}.{$fileext}', 'page'=>'/{$typedir}/{$prefix}_{$page}.{$fileext}');
$urlrule['html']['type'][1] = array('example'=>'/htmldir/rent_1.html','index'=>'/{$htmldir}/{$prefix}.{$fileext}', 'page'=>'/{$htmldir}/{$prefix}_{$page}.{$fileext}');
$urlrule['html']['type'][2] = array('example'=>'/rent_2_1.html','index'=>'/{$prefix}_{$typedir}.{$fileext}', 'page'=>'/{$prefix}_{$typedir}_{$page}.{$fileext}');

$urlrule['html']['item'][0] = array('example'=>'/2007/1010/rent_1.html','index'=>'/{$year}/{$month}{$day}/{$prefix}{$itemid}.{$fileext}');
$urlrule['html']['item'][1] = array('example'=>'/rent/200710/rent_1.html','index'=>'{$typedir}/{$year}{$month}/{$prefix}{$itemid}.{$fileext}');

$urlrule['php']['type'][0] = array('example'=>'/listinfo.php?infocat=1&page=2','index'=>'/listinfo.php?infocat={$infocat}', 'page'=>'/listinfo.php?infocat={$infocat}&page={$page}');
$urlrule['php']['type'][1] = array('example'=>'/listinfo.php?infocat-1/page-2.html','index'=>'/listinfo.php?infocat-{$infocat}.html', 'page'=>'/listinfo.php?infocat-{$infocat}/page-{$page}.html');
$urlrule['php']['type'][2] = array('example'=>'/listinfo-1-2.html','index'=>'/list-{$infocat}-1.html', 'page'=>'/listinfo-{$infocat}-{$page}.html');

$urlrule['php']['item'][0] = array('example'=>'/showinfo.php?houseid=1','index'=>'/showinfo.php?houseid={$itemid}');
$urlrule['php']['item'][1] = array('example'=>'/showinfo.php?houseid-1.html','index'=>'/showinfo.php?houseid-{$itemid}.html');
$urlrule['php']['item'][2] = array('example'=>'/showinfo-1.html','index'=>'/showinfo-{$itemid}.html');


//楼盘地址形式
$displayrule['html']['list'][0] = array('example'=>'/newhouse/list_2.html','index'=>'/newhouse/{$index}.{$fileext}', 'page'=>'/newhouse/{$prefix}{$page}.{$fileext}');

$displayrule['html']['list'][1] = array('example'=>'/htmldir/list_1.html','index'=>'/{$htmldir}/{$index}.{$fileext}', 'page'=>'/{$htmldir}/{$prefix}{$page}.{$fileext}');

$displayrule['html']['list'][2] = array('example'=>'/displaylist_1.html','index'=>'/displaylist.{$fileext}', 'page'=>'/displaylist_{$page}.{$fileext}');

$displayrule['html']['item'][0] = array('example'=>'/2006/1010/newhouse_1.html','index'=>'/{$year}/{$month}{$day}/newhouse_{$itemid}.{$fileext}');
$displayrule['html']['item'][1] = array('example'=>'/displaylist/2006/1010/newhouse_1.html','index'=>'/displaylist/{$year}{$month}/newhouse_{$itemid}.{$fileext}');
$displayrule['html']['item'][2] = array('example'=>'/newhouse_1.html','index'=>'/newhouse_{$itemid}.{$fileext}');

$displayrule['php']['list'][0] = array('example'=>'/listdisplay.php?page=2','index'=>'/listdisplay.php', 'page'=>'/listdisplay.php?page={$page}');
$displayrule['php']['list'][1] = array('example'=>'/listdisplay.php?page-2.html','index'=>'/listdisplay.php', 'page'=>'/listdisplay.php?page-{$page}.html');
$displayrule['php']['list'][2] = array('example'=>'/listdisplay-2.html','index'=>'/listdisplay-1.html', 'page'=>'/listdisplay-{$page}.html');

$displayrule['php']['item'][0] = array('example'=>'/newhouse.php?displayid=1','index'=>'/newhouse.php?displayid={$itemid}');
$displayrule['php']['item'][1] = array('example'=>'/newhouse.php?displayid-1.html','index'=>'/newhouse.php?displayid-{$itemid}.html');
$displayrule['php']['item'][2] = array('example'=>'/newhouse-1.html','index'=>'/newhouse{$itemid}.html');

?>