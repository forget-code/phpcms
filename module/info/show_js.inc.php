<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$infoid = isset($itemid) ? intval($itemid) : 0;
if(!$infoid) exit;
$r = $db->get_one("select infoid,username,hits,comments from ".channel_table('info', $channelid)." where infoid=$infoid ", "CACHE");
if($r['infoid'])
{
	$db->query("update ".channel_table('info', $channelid)." set hits=hits+1 where infoid=$infoid ");
	echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
	echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){}\n";
}
$u = $db->get_one("select groupid,lastlogintime,email,showemail from ".TABLE_MEMBER." where username='$r[username]' ", "CACHE");
if($u['groupid'])
{
	$groups = cache_read("member_group.php");
	echo "try {setidval('span_group','".$groups[$u['groupid']]['groupname']."');}catch(e){}\n";
	if($u['showemail'])
	{
		echo "try {setidval('span_email','".$u['email']."');}catch(e){}\n";
	}
	else
	{
		echo "try {setidval('span_email',".$LANG['unacknowledged_email'].");}catch(e){}\n";
	}
	echo "try {setidval('span_lastlogintime','".date('Y-m-d H:i:s',$u['lastlogintime'])."');}catch(e){}";
}
?>