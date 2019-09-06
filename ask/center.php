<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login'],$MODULE['member']['url'].'login.php?forward='.urlencode(URL));

require MOD_ROOT.'include/ask.class.php';
$ask = new ask();
require_once MOD_ROOT.'include/credit.class.php';
$credit = new credit();
require_once MOD_ROOT.'include/answer.class.php';
$answer = new answer();
require_once PHPCMS_ROOT.'member/include/member.class.php';
$member = new member();

if(!isset($action)) $action = 'ask';
switch($action)
{
	case 'ask':
		if(isset($status)) $status = intval($status);
		if(isset($flag)) $flag = intval($flag);
		$sql = 'userid='.$_userid;
		if($status == 3 || $status == 5)
		{
			$sql .= " AND status=".$status;
		}
		else if($flag == 1)
		{
			$sql .= ' AND flag=1';
		}
		else if($flag == -1)
		{
			$endtime = TIME-1296000;
			$sql .= ' AND status = 3 AND addtime<'.$endtime;
		}
		$infos = $ask->listinfo($sql, 'askid DESC', $page, 20);
		$pages = $ask->pages;
		$head['title'] = '提问管理_问吧_'.$PHPCMS['sitename'];
		include template('ask', 'center_ask');
	break;

	case 'answer':
		$infos = $answer->listinfo("userid='$_userid' AND isask=0", 'pid DESC', $page, 20);
		$pages = $answer->pages;
		$head['title'] = '我的回答_问吧_'.$PHPCMS['sitename'];
		include template('ask', 'center_answer');
	break;

	case 'actor':
		if($dosubmit)
		{
			$member->edit($info);
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			$array = $member->get($_userid,'i.actortype',1);
			$actortype = $array['actortype'];
			$TYPES = explode("\n", $M['member_group']);
			$ACTOR = cache_read('actor.php');
		    $head['title'] = '修改头衔_问吧_'.$PHPCMS['sitename'];
			include template('ask', 'center_actor');
		}
	break;

	case 'credit':
		$asknumber = $ask->getnumber($_userid,0);
		$answernumber = $ask->getnumber($_userid,1);
		$result = $credit->get($_userid);
		@extract($result);
		$array = $member->get($_userid,'i.actortype',1);
		$actortype = $array['actortype'];
		$head['title'] = '查看积分_问吧_'.$PHPCMS['sitename'];
		include template('ask', 'center_credit');
	break;

	case 'edit':
		if($job=='ask')
		{
			if($dosubmit)
			{
				if($info['title'] == '') showmessage($LANG['title_no_allow_blank'],'goback');
				$info['title'] = htmlspecialchars($info['title']);
				$posts['message'] = $M['use_editor'] ? $posts['message'] : strip_tags($posts['message']);
				$ask->edit($id, $info, $posts, $_userid);
				showmessage($LANG['operation_success'],$forward);
			}
			else
			{
				$r = $ask->detail($id,'a.title,p.message,a.status', 1);
				if(!$r) showmessage('提问不存在');
				extract($r);
				if($status>3) showmessage($LANG['no_edit'],"goback");
		        $head['title'] = '修改提问_问吧_'.$PHPCMS['sitename'];
				include template('ask', 'center_edit');
			}
		}
		else
		{
			if($dosubmit)
			{
				$answer->edit($id, $posts, $_userid);
				showmessage($LANG['operation_success'], $forward);
			}
			else
			{
				$r = $answer->get($id, 'a.status,p.message', 1);
				if(!$r) showmessage('回答不存在');
				extract($r);
		        $head['title'] = '修改回答_问吧_'.$PHPCMS['sitename'];
				include template('ask', 'center_edit');
			}

		}
	break;
}
?>