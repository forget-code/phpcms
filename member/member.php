<?php
require './include/common.inc.php';

$m = $db->get_one("SELECT * FROM ".TABLE_MEMBER." m , ".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid AND m.username='$username' ","CACHE",86400);
if(!$m) showmessage($LANG['username_not_exist']);
@extract($m);

$userface = $userface ? $userface : PHPCMS_PATH."member/images/defaultface.gif";
$facewidth = $facewidth ? $facewidth : 150;
$faceheight = $faceheight ? $faceheight : 172;
$gender = $gender ? $LANG['male'] : $LANG['female'];
$birthday = $birthday == "0000-00-00" ? $LANG['unknown'] : $birthday;

$head['title'] = $username.$LANG['s_florilegium'];

if(isset($module) || $channelid)
{
	if($channelid)
	{
		$CHA = cache_read('channel_'.$channelid.'.php');
		$module = $CHA['module'];
	}
	array_key_exists($module,$MODULE) or showmessage($LANG['illegal_parameters']);
	$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
	$page = isset($page) ? intval($page) : 1;
	$offset = $page ? ($page-1)*$pagesize : 0;
	$r = $db->get_one("SELECT count(*) as number FROM ".channel_table($module, $channelid)." WHERE username='$username' AND status=3 ", "CACHE", 7200);
	$totalnumber = $r['number'];
	$pages = phppages($totalnumber, $page, $pagesize);
	$result = $db->query("SELECT * FROM ".channel_table($CHA['module'], $channelid)."  WHERE username='$username' AND status=3 ORDER BY addtime DESC LIMIT $offset,$pagesize", "CACHE", 7200);
	$items = array();
	while($r = $db->fetch_array($result))
	{
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['title'] = style($r['title'], $r['style']);
		$r['adddate'] = date("Y-m-d",$r['addtime']);
		$items[] = $r;
	}
	include template('member', 'member_item');
}
else
{
	$cha = array();
	$items = array();
	foreach($CHANNEL as $channel)
	{
		if($channel['islink']) continue;
		$channelid = $channel['channelid'];
		$CHA = cache_read('channel_'.$channelid.'.php');
		if($CHA['islink'] || !$CHA['enablecontribute']) continue;
		$cha[$channelid]['linkurl'] = $CHA['linkurl'];
		$cha[$channelid]['channelname'] = $CHA['channelname'];

		$r = $db->get_one("SELECT count(*) as number FROM ".channel_table($CHA['module'], $channelid)." WHERE username='$username' AND status=3 ", "CACHE", 7200);
		$cha[$channelid]['itemnumber'] = $r['number'];
		$items[$channelid] = array();
		$result = $db->query("SELECT * FROM ".channel_table($CHA['module'], $channelid)."  WHERE username='$username' AND status=3 ORDER BY addtime DESC LIMIT 0,10", "CACHE", 7200);
		while($r = $db->fetch_array($result))
		{
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['title'] = style($r['title'], $r['style']);
			$r['adddate'] = date("Y-m-d",$r['addtime']);
			$items[$channelid][] = $r;
		}
	}
	$channelid = 0;
	include template('member', 'member');
}
?>