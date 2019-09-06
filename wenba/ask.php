<?php 
require_once './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
$overdue = $db->get_one("SELECT count(*) AS num FROM ".TABLE_WENBA_QUESTION." WHERE username='$_username' AND endtime<'$PHP_TIME' AND status=1");
@extract($overdue);
if($num)
{
	showmessage($LANG['deal_with_past_problem'], $CHA['linkurl'].'member_index.php');
}
require PHPCMS_ROOT.'/include/tree.class.php';
$tree = new tree;
$CATEGORY = cache_read('categorys_'.$mod.'.php');
require PHPCMS_ROOT.'/include/formselect.func.php';
$qtitle=empty($qtitle) ? '' : trim(strip_tags($qtitle));
$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');
if($dosubmit)
{
	if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_an_ask'], 'goback');
	$qtitle = isset($qtitle) ? trim(strip_tags($qtitle)) : showmessage($LANG['input_your_problem'],goback);
	$qsupply = isset($qsupply) ? trim(strip_tags($qsupply)) : '';
	$catid = isset($catid) ? intval($catid) : showmessage($LANG['please_choose_first_cat'],goback);
	$hid_score = isset($hidname) ? $MOD['anybody_score'] : 0;
	$givescore = isset($givescore) ? intval($givescore) : 0;
	$my_score = intval($myscore);
	if($givescore > $my_score) showmessage($LANG['give_credit_is_high'],goback);
	$point = $givescore+$hid_score;
	if(isset($MODULE['pay']))
	{
		require_once PHPCMS_ROOT.'/pay/include/pay.func.php';	
		credit_diff($_username,$point,$LANG['give_credit'].$qtitle, $_userid);
	}
	update_score($_username,$point,0);
	$endtime = $PHP_TIME+1296000;

	$db->query("INSERT INTO ".TABLE_WENBA_QUESTION."(catid,username,score,title,content,asktime,endtime,status,hidname) VALUES('$catid','$_username','$givescore','$qtitle','$qsupply','$PHP_TIME','$endtime',1,'$hidname')");
	
	$db->query("UPDATE ".TABLE_CATEGORY." SET items=(items+1) WHERE catid=$catid");
	extract($db->get_one("SELECT COUNT(qid) AS number FROM ".TABLE_WENBA_QUESTION." WHERE catid=$catid"));
	$db->query("UPDATE ".TABLE_CATEGORY." SET items=$number WHERE catid=$catid AND module='wenba'");
	
	showmessage($LANG['ask_publish_success'], $CHA['linkurl'].'index.php');
}
else
{
	@extract($db->get_one("SELECT credit AS my_score FROM ".TABLE_MEMBER." WHERE username='$_username'"));
	@extract($db->get_one("SELECT count(*) AS num FROM ".TABLE_WENBA_QUESTION." WHERE status=2 AND title LIKE '%$qtitle%'"));
	if($num)
	{
		$req_r = $db->query("SELECT qid,title FROM ".TABLE_WENBA_QUESTION." WHERE status=2 AND title LIKE '%$qtitle%'");
		while($r=$db->fetch_array($req_r))
		{
			$ques_list[] = $r;
		}
	}
	include template('wenba','ask');
}
?>