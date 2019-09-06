<?php
require './include/common.inc.php';
if(!class_exists('member'))
{
	require $MODULE['member']['url'].'include/member.class.php';
}
if(!$_userid)  showmessage('请登录后再发送短消息', $MODULE['member']['url'].'login.php?forward='.urlencode(URL));
if(!isset($forward)) $forward = HTTP_REFERER;

switch($action)
{
	case 'checkuser':
		$arr_user = explode(',', $value);
		foreach($arr_user as $username)
		{
			$userid = $member->get_userid($username);
			if(!$userid) exit($username.'会员不存在');
			$result = $member->get($userid, 'disabled');
			if($result['disabled']) exit($username.'已经被禁用');
		}
		exit('success');
	break;
	default:
		if($dosubmit)
		{
			$arr_user = explode(',', $msgto);
			foreach($arr_user as $username)
			{
				$member = new member;
				$msgtoid = $member->get_userid($username);
				if(!$message->send_new($msgtoid, $_userid, $subject, $content, $savetooutbox))
				{
					showmessage($message->msg(), $forward);
				}
				$memberinfo = array('userid'=>$msgtoid, 'message'=>1);
				$member->edit($memberinfo);
			}	
			unset($arr_msgtoname, $message_limit, $num_message, $member);
			showmessage($LANG['message_send_successful'], $forward);
		}
		else
		{
			require PHPCMS_ROOT.'include/form.class.php';
			$head['title'] = $LANG['send_msg'];
			if(isset($userid))
			{
				$member = new member;
				$result = $member->get($userid);
				$username = $result['username'];
			}
			include template($mod, 'send');
		}
	break;
}
?>