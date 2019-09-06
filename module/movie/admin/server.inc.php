<?php
defined('IN_PHPCMS') or exit('Access Denied');
$serverid = $serverid ? intval($serverid) : 1;
$submenu = array(
	array("<font color=\"blue\">".$LANG['add_server']."</font>","?mod=$mod&file=$file&action=add&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['manage_server']."</font>","?mod=$mod&file=$file&action=manage&channelid=$channelid")
);

$menu = adminmenu($LANG['manage_server'],$submenu);
$action = $action ? $action : 'manage';
switch($action)
{
	case 'add':
		if(isset($submit))
		{
			$db->query("INSERT INTO ".TABLE_MOVIE_SERVER." (`onlineurl` , `downurl` , `servername` ,`isapi` , `maxnum`) VALUES ('$onlineurl','$downurl','$servername','$isapi','$maxnum')");
			showmessage($LANG['operation_success'],'?mod=movie&file=server&action=manage');
			
		}
		include admintpl('server_add');
	break;

	case 'manage':
		$server = array();
		$result = $db->query("SELECT * FROM ".TABLE_MOVIE_SERVER);
		while($r=$db->fetch_array($result))
		{
			$server[] = $r;
		}
	include admintpl('server_manage');
	break;

	case 'edit':
		if(isset($submit))
		{
			$db->query("UPDATE ".TABLE_MOVIE_SERVER." SET onlineurl = '$onlineurl',downurl = '$downurl',isapi = '$isapi',servername = '$servername',maxnum = '$maxnum' WHERE serverid =".$serverid);
			showmessage($LANG['operation_success'],'?mod=movie&file=server&action=manage');
		}
		else
		{
			extract($db->get_one("SELECT * FROM ".TABLE_MOVIE_SERVER." WHERE serverid =".$serverid.""));
			include admintpl('server_edit');
		}
	break;

	case 'delete':
		if(empty($serverid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$db->query("DELETE FROM ".TABLE_MOVIE_SERVER." WHERE serverid = $serverid");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],'?mod=movie&file=server&action=manage');
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;

	case 'destroy':
		$db->query("UPDATE ".TABLE_MOVIE_SERVER." SET `num` = 0 WHERE serverid = $serverid ");
		showmessage($LANG['operation_success'],'?mod=movie&file=server&action=manage');
	break;
}
?>