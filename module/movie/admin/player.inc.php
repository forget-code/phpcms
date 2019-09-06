<?php
defined('IN_PHPCMS') or exit('Access Denied');
$playerid = $playerid ? intval($playerid) : 1;
$submenu = array(
	array("<font color=\"blue\">".$LANG['add_player']."</font>","?mod=$mod&file=$file&action=add&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['manage_player']."</font>","?mod=$mod&file=$file&action=manage&channelid=$channelid")
);

$menu = adminmenu($LANG['manage_player'],$submenu);
$action = $action ? $action : 'manage';
switch($action)
{
	case 'add':
		if(isset($submit))
		{
			$db->query("INSERT INTO ".TABLE_MOVIE_PLAYER." (`subject` , `code`) VALUES ('$subject','$code')");
			showmessage($LANG['operation_success'],'?mod=movie&file=player&action=manage');
			
		}
		include admintpl('player_add');
	break;

	case 'edit':
		if(isset($submit))
		{
			$db->query("UPDATE ".TABLE_MOVIE_PLAYER." SET subject = '$subject',code = '$code' WHERE playerid =".$playerid);
			showmessage($LANG['operation_success'],'?mod=movie&file=player&action=manage');
		}
		else
		{
			extract($db->get_one("SELECT * FROM ".TABLE_MOVIE_PLAYER." WHERE playerid =".$playerid.""));
			include admintpl('player_edit');
		}
	break;

	case 'manage':
		$movie = array();
		$sql = "SELECT playerid,subject,disabled,iscore FROM ".TABLE_MOVIE_PLAYER." ";
		$result = $db->query("$sql");
		while($r=$db->fetch_array($result))
		{
			$movie[] = $r;
		}
		include admintpl('player_manage');
	break;

	case 'delete':
		if(empty($playerid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$playerids=is_array($playerid) ? implode(',',$playerid) : $playerid;
		$db->query("DELETE FROM ".TABLE_MOVIE_PLAYER." WHERE playerid IN ($playerids)");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
		
	break;

	case 'disabled' :
		if(empty($playerid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		if(!ereg('^[0-1]+$',$disabled))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$playerids=is_array($playerid) ? implode(',',$playerid) : $playerid;
		$db->query("UPDATE ".TABLE_MOVIE_PLAYER." SET disabled=$disabled WHERE playerid IN ($playerids)");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;
}


?>