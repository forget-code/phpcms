<?php
defined('IN_PHPCMS') or exit('Access Denied');

$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$PHPCMS['pagesize'];
$result = $db->query("SELECT count(mailid) as num FROM ".TABLE_MAIL);
$r = $db->fetch_array($result);
$number = $r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);

$query ="SELECT mailid,typeid,title,addtime,sendtime,username,period   ".
		"FROM ".TABLE_MAIL.
		" order by period desc limit $offset,".$PHPCMS['pagesize'];

$result = $db->query($query);
$mails = array();
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d',$r['addtime']);
	$r['sendtime'] = $r['sendtime'] ? date('Y-m-d',$r['sendtime']) : '<font color=red>'.$LANG['not_send'].'</font>';	
	$mails[] = $r;
}
include admintpl('subscription_manage');
?> 