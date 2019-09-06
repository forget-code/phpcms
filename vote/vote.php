<?php
require_once './include/common.inc.php';
if(!isset($op)) showmessage($LANG['vote_option_null'],'goback');
$voteid = intval($voteid);
$forward = $forward ? $forward : $forward;
$_username = $_username ? $_username : '';
@extract($db->get_one("SELECT voteid,attribute FROM ".TABLE_VOTE_SUBJECT." WHERE passed = 1 AND voteid = '$voteid'"));
if(!$attribute)//Forbid guest vote
{
	if(!$_userid)
	{
		showmessage($LANG['guest_forbid'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
	}
	else
	{
		$r = $db->get_one("SELECT voteuser FROM ".TABLE_VOTE_DATA." WHERE voteid = '$voteid'");
		if($r['voteuser']!='')
		{
			if($r['voteuser'] == $_username)
			showmessage($LANG['already_vote'],'goback');
		}
		$optionids = is_array($op) ? implode(',',$op) : intval($op);		
		if($optionids) $optionids = new_addslashes($optionids);
		$totalnumberadd = is_array($op) ? count($op) : 1;

		$db->query("UPDATE ".TABLE_VOTE_OPTION." SET number = number+1 WHERE optionid IN ($optionids) ");
		$db->query("UPDATE ".TABLE_VOTE_SUBJECT." SET totalnumber = totalnumber+$totalnumberadd WHERE voteid = '$voteid'");
		$db->query("INSERT INTO ".TABLE_VOTE_DATA." (`voteid` , `voteuser` , `votetime` ,`ip`) VALUES ('$voteid','$_username','$PHP_TIME','$PHP_IP')");
		showmessage($LANG['thanks_vote'],PHPCMS_PATH.'vote/show.php?voteid='.$voteid);
	}
}
else
{//Allow guest vote
	$optionids = is_array($op) ? implode(',',$op) : intval($op);
	if($optionids) $optionids = new_addslashes($optionids);
	$totalnumberadd = is_array($op) ? count($op) : 1;
	//Inspects ip in the same day whether already voted
	$outTime= (int)($PHP_TIME - 24*60*60);
	$result = $db->query("SELECT votetime,ip FROM ".TABLE_VOTE_DATA." WHERE voteid = '$voteid' AND ip = '$PHP_IP' AND votetime > '$outTime'");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['cannot_vote_again_24'],'goback');
	}
	else
	{
		$db->query("UPDATE ".TABLE_VOTE_OPTION." SET number = number+1 WHERE optionid IN ($optionids) ");
		$db->query("UPDATE ".TABLE_VOTE_SUBJECT." SET totalnumber = totalnumber+$totalnumberadd WHERE voteid = '$voteid'");
		$db->query("INSERT INTO ".TABLE_VOTE_DATA." (`voteid` , `voteuser` , `votetime` ,`ip`) VALUES ('$voteid','$_username','$PHP_TIME','$PHP_IP')");
		showmessage($LANG['thanks_vote'],PHPCMS_PATH.'vote/show.php?voteid='.$voteid);
	}
}
?>