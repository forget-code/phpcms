<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$articleid = isset($itemid) ? intval($itemid) : 0;
if(!$articleid) exit;
if($MOD['show_hits'])
{
	$r = $db->get_one("select articleid,catid,hits,comments from ".channel_table('article', $channelid)." where articleid=$articleid ", "CACHE");
	if($r['articleid'])
	{
		$db->query("update ".channel_table('article', $channelid)." set hits=hits+1 where articleid=$articleid ");
		echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
		echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){}\n";
	}
}

if($MOD['show_pre_and_next'])
{
	if(!isset($r))
	{
		$r = $db->get_one("select catid from ".channel_table('article', $channelid)." where articleid=$articleid ", "CACHE");
	}

	$p = $db->get_one("select articleid,title,linkurl,style from ".channel_table('article', $channelid)." where status=3 and catid='$r[catid]' and articleid<$articleid limit 0,1", "CACHE");
	if($p['articleid'])
	{
		$p['stitle'] = style($p['title'], $p['style']);
		$p['linkurl'] = linkurl($p['linkurl']);
		$pre = '<li>'.$LANG['prepage'].'<a href="'.$p['linkurl'].'">'.$p['title'].'</a></li>';
	}
	else
	{
		$pre = '<li>'.$LANG['prepage'].$LANG['none'].'</li>';
	}

	$n = $db->get_one("select articleid,title,linkurl,style from ".channel_table('article', $channelid)." where status=3 and catid='$r[catid]' and articleid>$articleid limit 0,1", "CACHE");
	if($n['articleid'])
	{
		$n['stitle'] = style($n['title'], $n['style']);
		$n['linkurl'] = linkurl($n['linkurl']);
		$next = '<li>'.$LANG['nextpage'].'<a href="'.$n['linkurl'].'">'.$n['title'].'</a></li>';
	}
	else
	{
		$next = '<li>'.$LANG['nextpage'].$LANG['none'].'</li>';
	}
	echo "try {setidval('pre_and_next','".$pre.$next."');}catch(e){}\n";
}
?>