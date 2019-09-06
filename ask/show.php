<?php
require './include/common.inc.php';
require_once MOD_ROOT.'include/global.func.php';
require_once MOD_ROOT.'include/output.func.php';
require_once MOD_ROOT.'include/answer.class.php';
$answer = new answer();
require_once PHPCMS_ROOT.'member/include/member.class.php';
$member = new member();
if($dosubmit && $action=='vote')
{
	if(!$_userid) showmessage($LANG['please_login'],$MODULE['member']['url'].'login.php?forward='.urlencode(URL));
	$answer->exchange($id,$check_answer, 1, 1, $_userid);
	showmessage($LANG['exchange_ask_to_vote'],ask_url($id));
}
else if($dosubmit)
{
	checkcode($checkcodestr, $M['answer_code'], $forward);
	if(!$_userid) showmessage($LANG['please_login'],$MODULE['member']['url'].'login.php?forward='.urlencode(URL));
	if(!$id) showmessage($LANG['illegal_parameters']);
	if(strlen($posts['message']) > 10000) showmessage('回答字数不能超过10000个字符');
	$posts['userid'] = $_userid;
	$posts['username'] = $_username;
	if($M['answer_check'])
	{
		$posts['status'] = 1;
	}
	else
	{
		$posts['status'] = 3;
	}
	$posts['addtime'] = TIME;
	$posts['message'] = $M['use_editor'] ? $posts['message'] : strip_tags($posts['message']);
	if($answer->add($id,$posts))
	{
		if($M['answer_check'])
		{
			showmessage($LANG['waitting_admin_check'],$forward);
		}
		else
		{
			showmessage($LANG['your_answer_submit_success'],$forward);
		}
	}
	else
	{
		showmessage('您已经回答了这个问题，您的答案正在审核当中，请等待...');
	}
}
else
{
	$array = $answer->show($id);
	if($array)
	{
		$answer->hits($id);
		$have_answer = false;
		foreach($array AS $k=>$v)
		{
			if($v['isask'])
			{
				$title = $v['title'];
				$message = $M['use_editor'] ? $v['message'] : format_textarea($v['message']);
				$reward = $v['reward'];
				$userid = $v['userid'];
				$username = $v['username'];
				$status = $v['status'];
				$flag = $v['flag'];
				$addtime = $v['addtime'];
				$actor = actor($v['actortype'], $v['point']);
				$answercount = $v['answercount'];
				$result = count_down($v['endtime']);
				$day = $result[0];
				$hour = $result[1];
				$minute = $result[2];
				$catid = $v['catid'];
				$anonymity = $v['anonymity'];
			}
			elseif($v['optimal'])
			{
				$solvetime = $v['solvetime'];
				$answer = $v['message'];
				$answertime = $v['addtime'];
				$answer = $v['message'];
				$optimail_username = $v['username'];
				$optimal_actor = actor($v['actortype'], $v['point']);
			}
			else
			{
				if($v['userid'] == $_userid) $have_answer = true;
				$infos[$k]['pid'] = $v['pid'];
				$infos[$k]['userid'] = $v['userid'];
				$infos[$k]['username'] = $v['username'];
				$infos[$k]['addtime'] = $v['addtime'];
				$infos[$k]['candidate'] = $v['candidate'];
				$infos[$k]['anonymity'] = $v['anonymity'];
				$infos[$k]['actor'] = actor($v['actortype'], $v['point']);
				$infos[$k]['message'] = $M['use_editor'] ? $v['message'] : format_textarea($v['message']);
			}
		}
		if($v['optimal'])
		{
			$answercount = $answercount-1;
		}
		if($userid == $_userid)
		{
			$isask = 1;
		}
		else
		{
			$isask = 0;
		}
		if(isset($action) && $action == 'vote')
		{
			if($flag==1) exit;
			$tpl = 'vote';
		}
		else
		{
			$tpl = 'show';
		}
		$head['keywords'] = $title;
		$head['description'] = $head['title'] = $title.'_'.$CATEGORY[$catid]['catname'].'_'.$M['name'].'_'.$PHPCMS['sitename'];
		include template('ask', $tpl);
	}
}
?>