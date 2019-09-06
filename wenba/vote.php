<?php
require_once './include/common.inc.php';

$username = trim($username);
$qid = intval($qid);
$aid = intval($aid);

if(!$_userid)
{
	echo 'A';
	exit;
}
if($username==$_username)
{
	echo 'D';
}
@extract($db->get_one("SELECT count(*) AS num FROM ".TABLE_WENBA_VOTE." WHERE username='$_username' AND qid=$qid"));
if($num)
{
	echo 'C';
	exit;
}

$ins_vote = $db->query("INSERT INTO ".TABLE_WENBA_VOTE." SET username='$_username',qid=$qid");

if(isset($MODULE['pay']))
{
	require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
	credit_add($username,$MOD['vote_give_credit'],$_username.$LANG['give_someboty_vote']);
}
$add_votecount = $db->query("UPDATE ".TABLE_WENBA_ANSWER." SET vote_count=vote_count+1 WHERE qid=$qid AND aid=$aid");
if($ins_vote && $add_votecount)
{
	echo 'B';
	exit;
}
?>