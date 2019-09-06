<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));

switch($action)
{
	case 'get_remaintime':
		require MOD_ROOT.'include/group.class.php';
		$group = new group();
		$array = $group->extend_get($_userid, $groupid, 'startdate, enddate');
		$data = $array['startdate'].'~'.$array['enddate'];
		exit($data);
	break;
	default:
		$memberinfo = $member->get($_userid, $fields = '*', 1);
		$memberinfo['avatar'] = avatar($_userid);
		@extract(new_htmlspecialchars($memberinfo));
		
		if(isset($MODULE['message']))
		{
			$message_api = load('message_api.class.php', 'message', 'api');
			$msg_num = $message_api->count_message($_userid, 'new');
			if($_userid && $msg_num < 1)
			{
				$arr_msg = array('userid'=>$_userid, 'message'=>0);
				$member->edit($arr_msg);
			}
		}
	break;
}
include template($mod, 'index');
?>