<?php 
defined('IN_PHPCMS') or exit('Access Denied');

include PHPCMS_ROOT.'/include/attachment.class.php';

function catname($catid)
{
	global $db;
	return $db->get_one("SELECT catname,linkurl FROM ".TABLE_CATEGORY." WHERE catid=$catid");
}

if($action == 'delete')
{
	if(!isset($aid) || empty($aid)) showmessage($LANG['illegal_operation']);
	$aid = is_array($aid) ? implode(',', $aid) : $aid;
	$result = $db->query("SELECT fileurl FROM ".TABLE_ATTACHMENT." WHERE aid IN($aid)");
	while($r = $db->fetch_array($result))
	{
		@unlink(PHPCMS_ROOT.'/'.$r['fileurl']);
    }
	$db->query("DELETE FROM ".TABLE_ATTACHMENT." WHERE aid IN($aid)");
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$pagesize = $PHPCMS['pagesize'];
	$page = isset($page) ? intval($page) : 1;
	$offset = $page == 1 ? 0 : ($page-1)*$pagesize;

    $sql = $keyname = '';
    if(isset($keyid))
	{
		$sql = " WHERE keyid='$keyid' ";
		$keyname = is_numeric($keyid) ? $CHANNEL[$keyid]['channelname'] : $MODULE[$keyid]['name'];

		$sql .= isset($itemid) ? " AND itemid='$itemid' " : '';
	}
	$r = $db->get_one("SELECT count(*) as number FROM ".TABLE_ATTACHMENT." $sql");
	$pages = phppages($r['number'], $page, $PHPCMS['pagesize']);

	$atts = array();
	$result = $db->query("SELECT * FROM ".TABLE_ATTACHMENT." $sql ORDER BY aid DESC LIMIT $offset,$pagesize");
	while($r = $db->fetch_array($result))
	{
		if(is_numeric($r['keyid']))
		{
			$r['keyname'] = $CHANNEL[$r['keyid']]['channelname'];
			$r['keyurl'] = $CHANNEL[$r['keyid']]['linkurl'];
		}
		else
		{
            $r['keyname'] = $MODULE[$r['keyid']]['name'];
			$r['keyurl'] = $MODULE[$r['keyid']]['linkurl'];
		}
		$r['cat'] = catname($r['catid']);
		$atts[$r['aid']] = $r;
	}
	include admintpl('attachment');
}
?>