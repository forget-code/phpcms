<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(empty($cid))
{
	showmessage($LANG['illegal_parameters']);
}
$cids = is_array($cid) ? implode(',',$cid) : $cid;
$result = $db->query("SELECT keyid,itemid,passed FROM ".TABLE_COMMENT." WHERE cid IN ($cids)");
while($r = $db->fetch_array($result))
{
	if($r['passed'] == 1) update_comments($r['keyid'], $r['itemid'], 0);
}
$db->query("DELETE FROM ".TABLE_COMMENT." WHERE cid IN ($cids)");
if($db->affected_rows()>0)
{
	showmessage($LANG['operation_success'], $referer);
}
else
{
	showmessage($LANG['operation_failure']);
}
?>