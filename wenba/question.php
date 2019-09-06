<?php
require_once './include/common.inc.php';

$qid = intval($qid);

if($dosubmit)
{
	$answer = trim(strip_tags($answer));
	$answertime = $PHP_TIME;
	if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
	$db->query("INSERT INTO ".TABLE_WENBA_ANSWER." SET qid='$qid',username='$_username',answer='$answer',answertime='$answertime'");
	
	$db->query("UPDATE ".TABLE_MEMBER." SET answercounts=(answercounts+1) WHERE username='$_username'");
	$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET answercount=(answercount+1) WHERE qid='$qid'");
	if($MOD['answer_give_credit'] && isset($MODULE['pay']))
	{
		require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
		$point = $MOD['answer_give_credit'];
		credit_add($_username, $point,$LANG['answer_encouragement']);
	}
	update_score($_username,$MOD['answer_give_credit'],1);
	showmessage("问题回复成功.", "question.php?qid=$qid");
}
else
{
	$clickcount_r = $db->query("UPDATE ".TABLE_WENBA_QUESTION." SET hits=(hits+1) WHERE qid=$qid");
	$ACTOR = cache_read('actors.php');
	@extract($db->get_one("SELECT * FROM ".TABLE_WENBA_QUESTION." WHERE qid=$qid"));
	$content = strip_textarea($content);
	$CATEGORY = cache_read('categorys_'.$mod.'.php');
	$position = catpos($catid);
	switch($status)
	{
		case '1':
			$left_time=$endtime-$PHP_TIME;
			$left_day=floor($left_time/86400);
			$left_hour=floor($left_time%86400/3600);
			$left_day=$left_day>0 ? $left_day : 0;
			$left_hour=$left_hour>0 ? $left_hour : 0;
		break;

		case '2':
			$introtimes = date('Y-m-d H:i',$introtime);
		break;

		case '3':
			$left_votetime=$endtime-$PHP_TIME;
			$left_voteday=floor($left_votetime/86400);
			$left_votehour=floor($left_votetime%86400/3600);
			$left_voteday=$left_voteday>0 ? $left_voteday : 0;
			$left_votehour=$left_votehour>0 ? $left_votehour : 0;
		break;
	}
	
	$asktime = date('Y-m-d h:i',$asktime);
	$askusername = $username;
	@extract($db->get_one("SELECT credit,actortype FROM ".TABLE_MEMBER." WHERE username='$askusername'"));
	if(!$actortype) $actortype = 0;
	$acts = $ACTOR[$actortype];
	foreach($acts As $k=>$v)
	{
		if($credit>=$v['min'] && $credit<=$v['max'])
		{
			$user_grade = $v['grade'];
			$user_actor = $v['actor'];
		}
		elseif($credit>$v['max'])
		{
			$user_grade = $v['grade'];
			$user_actor = $v['actor'];
		}
	}
	@extract($db->get_one("SELECT count(*) AS longinanswer FROM ".TABLE_WENBA_ANSWER." WHERE username='$_username' AND qid='$qid'"));
	@extract($db->get_one("SELECT count(*) AS answer_count FROM ".TABLE_WENBA_ANSWER." WHERE qid='$qid'"));

	$answer_r = $db->query("SELECT a.aid,a.username,a.answer,a.answertime,b.credit,b.actortype FROM ".TABLE_WENBA_ANSWER." AS a LEFT JOIN ".TABLE_MEMBER." AS b ON a.username=b.username WHERE a.qid='$qid' ORDER BY a.aid ASC");
	while($r = $db->fetch_array($answer_r))
	{
		$r['answertime'] = date('Y-m-d h:i',$r['answertime']);
		$r['answer'] = strip_textarea($r['answer']);
		if(!$r['actortype']) $r['actortype'] = 0;
		$acts = $ACTOR[$r['actortype']];
		foreach($acts As $k=>$v)
		{
			if($r['credit']>=$v['min'] && $r['credit']<=$v['max'])
			{
				$r['answer_grade'] = $v['grade'];
				$r['answer_actor'] = $v['actor'];
			}
			elseif($r['credit']>$v['max'])
			{
				$r['answer_grade'] = $v['grade'];
				$r['answer_actor'] = $v['actor'];
			}
		}
		$answer_list[] = $r;
	}

	$question_allowanswer = ($username!=$_username && !$longinanswer && $status==1) ? 1 : 0;//我要回答
	$question_allowhandle = ($status==1 && $username==$_username) ? 1 : 0;//提高悬赏 问题补充
	$question_allowsetvote = $answer_count>1 ? 1 : 0;//发起投票

	@extract($db->get_one("SELECT a.username AS good_username,a.answer,a.answertime AS good_answertime,b.credit AS gcredit,b.actortype FROM ".TABLE_WENBA_ANSWER." AS a LEFT JOIN ".TABLE_MEMBER." AS b ON a.username=b.username WHERE a.qid='$qid' AND a.accept_status=1"));
	if(!$actortype) $actortype = 0;
	$acts = $ACTOR[$actortype];
	foreach($acts As $k=>$v)
	{
		if($gcredit>=$v['min'] && $gcredit<=$v['max'])
		{
			$good_answer_grade = $v['grade'];
			$good_answer_actor = $v['actor'];
		}
		elseif($gcredit>$v['max'])
		{
			$good_answer_grade = $v['grade'];
			$good_answer_actor = $v['actor'];
		}
	}
	$good_answertime = date('Y-m-d h:i',$good_answertime);
	$good_answer = strip_textarea($answer);

	@extract($db->get_one("SELECT count(*) AS other_answer_count FROM ".TABLE_WENBA_ANSWER." WHERE qid='$qid' AND accept_status<>1"));
	$other_ques = $db->query("SELECT a.username AS other_username,a.answer AS other_answer,a.answertime AS other_answertime,b.credit AS other_answer_credit,b.actortype FROM ".TABLE_WENBA_ANSWER." AS a LEFT JOIN ".TABLE_MEMBER." AS b ON a.username=b.username WHERE a.qid='$qid' AND a.accept_status<>1 ORDER BY a.aid ASC");
	while($r = $db->fetch_array($other_ques))
	{
		if(!$r['actortype']) $r['actortype'] = 0;
		$acts = $ACTOR[$r['actortype']];
		foreach($acts As $k=>$v)
		{
			if($r['other_answer_credit']>=$v['min'] && $r['other_answer_credit']<=$v['max'])
			{
				$r['other_answer_grade'] = $v['grade'];
				$r['other_answer_actor'] = $v['actor'];
			}
			elseif($r['other_answer_credit']>$v['max'])
			{
				$r['other_answer_grade'] = $v['grade'];
				$r['other_answer_actor'] = $v['actor'];
			}
		}
		$r['other_answertime'] = date('Y-m-d h:i',$r['other_answertime']);
		$r['other_answer'] = strip_textarea($r['other_answer']);
		$other_queslist[]=$r;
	}

	@extract($db->get_one("SELECT count(*) AS vote_answer_count FROM ".TABLE_WENBA_ANSWER." WHERE qid='$qid' AND prepare_status=1"));
	$vote_ques = $db->query("SELECT a.aid,a.username AS vote_username,a.answer AS vote_answer,a.answertime AS vote_answertime,b.credit AS vote_answer_credit,b.actortype FROM ".TABLE_WENBA_ANSWER." AS a LEFT JOIN ".TABLE_MEMBER." AS b ON a.username=b.username WHERE a.qid='$qid' AND a.prepare_status=1 ORDER BY a.aid ASC");
	while($r = $db->fetch_array($vote_ques))
	{
		if(!$r['actortype']) $r['actortype'] = 0;
		$acts = $ACTOR[$r['actortype']];
		foreach($acts As $k=>$v)
		{
			if($r['vote_answer_credit']>=$v['min'] && $r['vote_answer_credit']<=$v['max'])
			{
				$r['vote_answer_grade'] = $v['grade'];
				$r['vote_answer_actor'] = $v['actor'];
			}
			elseif($r['vote_answer_credit']>$v['max'])
			{
				$r['vote_answer_grade'] = $v['grade'];
				$r['vote_answer_actor'] = $v['actor'];
			}
		}
		$r['vote_answertime'] = date('Y-m-d h:i',$r['vote_answertime']);
		$r['vote_answer'] =strip_textarea($r['vote_answer']);
		$vote_queslist[]=$r;
	}
}
include template('wenba','question');
?>