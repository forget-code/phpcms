<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/admin/include/special.class.php';

$channelid = intval($channelid);
$channelid or showmessage($LANG['illegal_parameters'],$forward);

$keyid = $channelid;
$submenu = array
(
	array($LANG['manage_index'], '?mod=phpcms&file=special&action=manage&keyid='.$keyid),
	array($LANG['add_special'], '?mod=phpcms&file=special&action=add&keyid='.$keyid),
	array($LANG['update_special_link'], '?mod=phpcms&file=special&action=update_linkurl&keyid='.$keyid),
	array($LANG['update_special_html'], '?mod=phpcms&file=special&action=createhtml&keyid='.$keyid),
);
$menu = adminmenu($LANG['specail_manage'], $submenu);

$specialid = intval($specialid);

$action = $action ? $action : 'manage';

if($action == 'add_itemids')
{
	if($dosubmit)
	{
		$spe = new special($channelid, $specialid);
		$special = $spe->get_info();
		if(isset($special['subspecial'])) showmessage($LANG['only_in_child_special']);
	    if(isset($pictureids) && is_array($pictureids)) $itemids = implode(',', $pictureids); 
		if($itemids) $db->query("UPDATE ".channel_table('picture', $channelid)." SET specialid=$specialid WHERE pictureid IN($itemids)");
        $forward = '?mod=phpcms&file=special&action=createhtml&keyid='.$channelid.'&forward='.urlencode($forward);
		showmessage($LANG['add_picture_to_special_success'], $forward);
	}
	else
	{
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;

		$itemids = $pictureids;
		$itemids = implode(',', $itemids);

		include admintpl('special_add_itemids', 'phpcms');
	}
}
elseif($action == 'delete_itemids')
{
	$pictureids = is_array($pictureids) ? implode(',', $pictureids) : $pictureid; 
	if($pictureids) $db->query("UPDATE ".channel_table('picture', $channelid)." SET specialid=0 WHERE pictureid IN($pictureids)");
    $forward = '?mod=phpcms&file=special&action=createhtml&keyid='.$channelid.'&forward='.urlencode($forward);

	showmessage($LANG['remove_picture_from_special_success'], $forward);
}
elseif($action == 'delete')
{
	$spe = new special($channelid, $specialid);
	$special = $spe->get_info();

    if($special['parentid'] > 0 || $special['arrchildid'] == '')
	{
		$specialids = $specialid;
	}
	else
	{
		$special = $spe->get_info($specialid);
		$specialids = $special['arrchildid'] ? $specialid.','.$special['arrchildid'] : $specialid;
	}

	$db->query("UPDATE ".channel_table('picture', $channelid)." SET specialid=0 WHERE specialid IN($specialids)");
    header('location:'.$forward);
}
else
{
	$specialid = isset($specialid) ? intval($specialid) : 0;
	$specialid or showmessage($LANG['specail_not_null']);

	$forward = urlencode($PHP_URL);

	$spe = new special($channelid, $specialid);

	$special = $spe->get_info();
	extract($special);
    
	if(isset($subspecialid))
	{
		$sql = " specialid=$subspecialid ";
	}
	else
	{
	    $sql = $parentid ? " specialid=$specialid " : " specialid IN($specialid,$arrchildid)";
	}

	$pictures = array();
	$query = "SELECT * FROM ".channel_table('picture', $channelid)." WHERE $sql ORDER BY listorder DESC, pictureid DESC ";
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		$r['title'] = style($r['title'], $r['style']);
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['adddate'] = date('Y-m-d', $r['addtime']);
		$r['addtime'] = date('Y-m-d H:i:s', $r['addtime']);
		$r['checktime'] = date('Y-m-d H:i:s', $r['checktime']);
		$r['edittime'] = date('Y-m-d H:i:s', $r['edittime']);
		$pictures[] = $r;
	}
	include admintpl('special_manage');
}
?>