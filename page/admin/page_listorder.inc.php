<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(empty($listorder) || !is_array($listorder))
{
	showmessage($LANG['illegal_parameters']);
}
foreach($listorder as $k=>$v)
{
	$db->query("UPDATE ".TABLE_PAGE." SET listorder='$v' WHERE pageid=$k AND keyid='$keyid'");
}
showmessage($LANG['operation_success'], $PHP_REFERER);
?>