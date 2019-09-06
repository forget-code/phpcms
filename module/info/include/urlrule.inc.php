<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$urlrule['php']['area'][0] = array('example'=>'/area.php?areaid=1&page=2','index'=>'/area.php?areaid={$areaid}', 'page'=>'/area.php?areaid={$areaid}&page={$page}');
$urlrule['php']['area'][1] = array('example'=>'/area.php?areaid-1/page-2.html','index'=>'/area.php?areaid-{$areaid}.html', 'page'=>'/area.php?areaid-{$areaid}/page-{$page}.html');
$urlrule['php']['area'][2] = array('example'=>'/area-1-2.html','index'=>'/area-{$areaid}-1.html', 'page'=>'/area-{$areaid}-{$page}.html');
?>