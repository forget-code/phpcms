<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(empty($pageid))
{
	showmessage($LANG['illegal_parameters']);
}
if(is_array($pageid))
{
	foreach($pageid as $v)
	{
		$r = $db->get_one("select pageid,filepath,linkurl from ".TABLE_PAGE." where pageid=$v and keyid='$keyid' ");
		if(!$r['pageid']) continue;
		if(!$r['linkurl']) @unlink(PHPCMS_ROOT."/".$r['filepath']);
	}
}
else
{
	$r = $db->get_one("select pageid,filepath,linkurl from ".TABLE_PAGE." where pageid=$pageid and keyid='$keyid' ");
	if($r['pageid'] && !$r['linkurl']) @unlink(PHPCMS_ROOT."/".$r['filepath']);
}

$pageids = is_array($pageid) ? implode(',',$pageid) : $pageid;
$db->query("DELETE FROM ".TABLE_PAGE." WHERE pageid IN ($pageids) and keyid='$keyid'");
showmessage($LANG['operation_success'], $PHP_REFERER);
?>