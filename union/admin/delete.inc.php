<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$userids = is_array($userid) ? implode(',', $userid) : $userid;
if($userids)
{
	$db->query("DELETE FROM ".TABLE_UNION." WHERE userid IN($userids)");
	$db->query("DELETE FROM ".TABLE_UNION_PAY." WHERE userid IN($userids)");
	$db->query("DELETE FROM ".TABLE_UNION_VISIT." WHERE userid IN($userids)");
}
showmessage('操作成功！', $PHP_REFERER);
?>