<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$urlrule['php']['cat'][0] = array('example'=>'/browse.php?catid=1&page=2','index'=>'/browse.php?catid={$catid}', 'page'=>'/browse.php?catid=1{$catid}&page={$page}');
?>