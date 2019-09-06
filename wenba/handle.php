<?php 
require_once './include/common.inc.php';
$qid = intval($qid);
$aid = intval($aid);
$option = trim($option);

switch($option)
{
	case 'ques_supply':
		$content = isset($content) ? trim(strip_tags($content)) : '';
		$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET content='$content' WHERE qid='$qid' AND username='$_username'");
		showmessage($LANG['your_problem_hava_repair'],"question.php?qid=$qid");
	break;

	case 'ques_addscore':
		$addscore = intval($addscore);
		@extract($db->get_one("SELECT credit FROM ".TABLE_MEMBER." WHERE username='$_username'"));
		if($addscore && $credit>=$addscore)
		{			
			$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET score=score+'$addscore',endtime=endtime+432000 WHERE qid='$qid' AND username='$_username'");	
			if(isset($MODULE['pay']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				credit_diff($_username,$addscore,$LANG['superaddition_credit'].$qid, $_userid);
			}
			update_score($_username,$addscore,0);
			showmessage($LANG['your_problem_credit_change'], "question.php?qid=$qid");			
		}
		else
		{
			showmessage($LANG['your_all_credit_is_lack'], "question.php?qid=$qid");
		}
	break;

	case 'ques_vote':
		$endtime = $PHP_TIME+432000;
		$item = is_array($check_answer) ? implode(',',$check_answer) : intval($check_answer);
		$db->query("UPDATE ".TABLE_WENBA_ANSWER." SET prepare_status=1 WHERE qid='$qid' AND aid IN ($item)");
		$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET status=3,endtime='$endtime' WHERE qid='$qid' AND username='$_username'");
		showmessage($LANG['problem_change_vote'], "question.php?qid=$qid");
	break;

	case 'ques_close':
		$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET status=4 WHERE qid='$qid' AND username='$_username'");
		showmessage($LANG['your_problem_close'], "question.php?qid=$qid");
	break;

	case 'ques_adopt':
		$introtime = $PHP_TIME;
		$response = isset($response) ? trim(strip_tags($response)) : '';
		$superadditionscore = isset($superadditionscore) ? intval($superadditionscore) : 0;
		$score = intval($score);
		$tx = '';
		if(($superadditionscore+$score) && isset($MODULE['pay']))
		{
			require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
			if($superadditionscore)
			{
				credit_diff($_username, $superadditionscore,$LANG['superfluity_credit_to'].$answername, $_userid);
				$tx = $LANG['superfluity_encouragement'].$superadditionscore.$LANG['cent'];
				update_score($_username,$superadditionscore,0);
			}
			credit_add($answername, $superadditionscore+$score,$LANG['answer_encouragement'].$tx);
			update_score($answername,$superadditionscore+$score,1);
		}
		$db->query("UPDATE ".TABLE_MEMBER." SET acceptcount=acceptcount+1 WHERE username='$answername'");
		$db->query("INSERT INTO ".TABLE_WENBA_RESPONSE." SET aid='$aid',qid='$qid',content='$response'");
		$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET status=2,introtime='$introtime' WHERE qid='$qid' AND username='$_username'");
		$db->query("UPDATE ".TABLE_WENBA_ANSWER." SET accept_status=1 WHERE aid='$aid' AND username='$answername'");
		showmessage($LANG['your_problem_have_deal'], "question.php?qid=$qid");
	break;

	case 'edit_answer':
		$answer = trim(strip_tags($answer));
		$db->query("UPDATE ".TABLE_WENBA_ANSWER." SET answer='$answer' WHERE aid='$aid' AND username='$_username'");
		showmessage($LANG['problem_repair_success'], "question.php?qid=$qid");
	break;

	case 'viewvote':
		$vote_sum = $db->get_one("SELECT sum(vote_count) AS num FROM ".TABLE_WENBA_ANSWER." WHERE qid=$qid AND prepare_status=1 GROUP BY prepare_status=1");
		@extract($vote_sum);
		$viewvote_r = $db->query("SELECT username,vote_count FROM ".TABLE_WENBA_ANSWER." WHERE qid=$qid AND prepare_status=1");
		while($r=$db->fetch_array($viewvote_r))
		{
			$r['view_vote'] =@round(($r['vote_count']/$num)*100,1)."%";
			$viewvotelist[] = $r;
		}
		include template('wenba','view_vote');
	break;
}
?>