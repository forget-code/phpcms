<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$urlrule['html']['cat'][0] = array('example'=>'/mobile/nokia/list_2.html','index'=>'{$parentdir}{$catdir}/{$index}.{$fileext}', 'page'=>'{$parentdir}{$catdir}/{$prefix}{$catid}_{$page}.{$fileext}');
$urlrule['html']['cat'][1] = array('example'=>'/htmldir/list_2_1.html','index'=>'/{$htmldir}/{$prefix}{$catid}.{$fileext}', 'page'=>'/{$htmldir}/{$prefix}{$catid}_{$page}.{$fileext}');

$urlrule['php']['cat'][0] = array('example'=>'/list.php?catid=1&page=2','index'=>'/list.php?catid={$catid}', 'page'=>'/list.php?catid={$catid}&page={$page}');
$urlrule['php']['cat'][1] = array('example'=>'/list.php?catid-1/page-2.html','index'=>'/list.php?catid-{$catid}.html', 'page'=>'/list.php?catid-{$catid}/page-{$page}.html');
$urlrule['php']['cat'][2] = array('example'=>'/list-1-2.html','index'=>'/list-{$catid}.html', 'page'=>'/list-{$catid}-{$page}.html');

$urlrule['php']['article'][0] = array('example'=>'/article.php?catid=1&page=2','index'=>'/article.php?catid={$tradeid}', 'page'=>'/article.php?catid={$tradeid}&page={$page}');
$urlrule['php']['trade'][0] = array('example'=>'/trade.php?tradeid=1&page=2','index'=>'/trade.php?tradeid={$tradeid}', 'page'=>'/trade.php?tradeid={$tradeid}&page={$page}');
$urlrule['php']['buy'][0] = array('example'=>'/buy.php?catid=1&page=2','index'=>'/buy.php?catid={$tradeid}', 'page'=>'/buy.php?catid={$tradeid}&page={$page}');
$urlrule['php']['sales'][0] = array('example'=>'/sales.php?catid=1&page=2','index'=>'/sales.php?catid={$tradeid}', 'page'=>'/buy.php?catid={$tradeid}&page={$page}');
?>