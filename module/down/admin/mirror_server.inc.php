<?php
$referer=isset($referer) ? $referer : "?mod=$mod&file=$file&channelid=$channelid";
switch($action){
case 'add':
	if(empty($url)) showmessage($LANG['image_server_not_empty'], 'goback');
	if(empty($name) && !$showtype) showmessage($LANG['show_name'], 'goback');
	if(empty($logo) && $showtype) showmessage($LANG['show_logo'], 'goback');
	if(substr($url, -1) != '/') $url .= '/';
	$db->query("INSERT INTO ".TABLE_DOWN_SERVER." (url,name,logo,showtype) VALUES('$url','$name','$logo','$showtype') ");
	showmessage($LANG['image_server_add_success'], $referer);
	break;
case 'delete':
	if(empty($sid))
	{
		showmessage($LANG['illegal_parameters'], 'goback');
	}
	$sids=is_array($sid) ? implode(',', $sid) : $sid;
	$db->query("DELETE FROM ".TABLE_DOWN_SERVER." WHERE sid IN ($sids)");
	showmessage($LANG['success_operation'], $referer);
	break;
case 'update':
	if(is_array($name))
	{
		foreach($name as $k => $v)
		{
			if(empty($url[$k])) showmessage($LANG['image_server_not_empty'], 'goback');
			if(empty($name[$k]) && !$showtype[$k]) showmessage($LANG['show_name'], 'goback');
			if(empty($logo[$k]) && $showtype[$k]) showmessage($LANG['show_logo'], 'goback');
			if(substr($url[$k], -1) != '/') $url[$k] .= '/';
			if(!isset($islock[$k])) $islock[$k] = 0;
			$db->query("UPDATE ".TABLE_DOWN_SERVER." SET listorder='$listorder[$k]',name='$name[$k]',url='$url[$k]',logo='$logo[$k]',showtype='$showtype[$k]',islock='$islock[$k]' WHERE sid=$k ");
		}
	}
	showmessage($LANG['success_operation'], $referer);
	break;
default:
	$servers = array();
	$query = "SELECT * FROM ".TABLE_DOWN_SERVER." ORDER BY listorder DESC";
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		$servers[$r['sid']] = $r;
	}
	cache_write('mirror_server.php', $servers);
	include admintpl('mirror_server');
}
?>