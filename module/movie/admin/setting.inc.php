<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	module_setting($mod, $setting);
	showmessage($LANG['setting_save_success'],$PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));

	$player_select = "<select name='setting[playerid]' ><option value='0'>选择播放器</option>";
	$result = $db->query("SELECT * FROM ".TABLE_MOVIE_PLAYER." WHERE disabled = 1");
	$selected = '';
	while($r=$db->fetch_array($result))
		{
			if($playerid == $r['playerid'])	$selected = 'selected';
			$player_select .= "<option value='".$r['playerid']."' ".$selected.">".$r['subject']."</option>";
			$selected = '';
		}
	$player_select .= "</select>";

	$server_select = "<select name='setting[serverid]' ><option value='0'>选择服务器</option>";
	$result = $db->query("SELECT * FROM ".TABLE_MOVIE_SERVER);
	while($r=$db->fetch_array($result))
		{
			if($MOD['serverid'] == $r['serverid'])	$selected = 'selected';
			$server_select .= "<option value='".$r['serverid']."' ".$selected.">".$r['servername']."播放".$r['onlineurl']."</option>";
			$selected = '';
		}
	$server_select .= "</select>";
    include admintpl('setting');
}
?>