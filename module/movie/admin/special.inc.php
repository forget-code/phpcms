<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/admin/include/special.class.php';

$channelid = intval($channelid);
$channelid or showmessage($LANG['invalid_parameters'], $forward);
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
	    if(isset($movieids) && is_array($movieids)) $itemids = implode(',', $movieids); 
		if($itemids) $db->query("UPDATE ".channel_table('movie', $channelid)." SET specialid=$specialid WHERE movieid IN($itemids)");
        $forward = '?mod=phpcms&file=special&action=createhtml&keyid='.$channelid.'&forward='.urlencode($forward);
		showmessage($LANG['add_movie_to_channel_success'], $forward);
	}
	else
	{
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;

		$itemids = $movieids;
		$itemids = implode(',', $itemids);

		include admintpl('special_add_itemids', 'phpcms');
	}
}
elseif($action == 'delete_itemids')
{
	$movieids = is_array($movieids) ? implode(',', $movieids) : $movieid; 
	if($movieids) $db->query("UPDATE ".channel_table('movie', $channelid)." SET specialid=0 WHERE movieid IN($movieids)");
    $forward = '?mod=phpcms&file=special&action=createhtml&keyid='.$channelid.'&forward='.urlencode($forward);
	showmessage($LANG['remove_movie_from_channel_success'], $forward);
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

	$db->query("UPDATE ".channel_table('movie', $channelid)." SET specialid=0 WHERE specialid IN($specialids)");
    header('location:'.$forward);
}
else
{
	$specialid = isset($specialid) ? intval($specialid) : 0;
	$specialid or showmessage($LANG['empty_special']);

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

	$movies = array();
	$query = "SELECT * FROM ".channel_table('movie', $channelid)." WHERE $sql ORDER BY listorder DESC, movieid DESC ";
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		$r['title'] = style($r['title'], $r['style']);
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['adddate'] = date("Y-m-d",$r['addtime']);
		$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
		$r['checktime'] = date("Y-m-d H:i:s",$r['checktime']);
		$r['edittime'] = date("Y-m-d H:i:s",$r['edittime']);
		$movies[] = $r;
	}
	include admintpl('special_manage');
}
?>