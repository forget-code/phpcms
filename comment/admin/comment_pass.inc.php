<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(empty($cid) || !ereg('^[0-1]+$', $passed))
{
	showmessage($LANG['illegal_parameters'], $referer);
}

$passed = intval($passed);
$cids = is_array($cid) ? implode(',', $cid) : $cid;
$db->query("UPDATE ".TABLE_COMMENT." SET passed=$passed WHERE cid IN ($cids)");
if($db->affected_rows() > 0)
{
	$result = $db->query("SELECT keyid,itemid FROM ".TABLE_COMMENT." WHERE cid IN ($cids)");
	while($r = $db->fetch_array($result))
	{
		$operation = $passed == 1 ? 1 : 0;
		update_comments($r['keyid'], $r['itemid'], $operation);
	}
	showmessage($LANG['operation_success'], $referer);
}
else
{
	showmessage($LANG['operation_failure']);
}
?>