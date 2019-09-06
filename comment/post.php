<?php
require './include/common.inc.php';

if(!$itemid || !$keyid || (!array_key_exists($keyid, $MODULE) && !array_key_exists($keyid, $CHANNEL))) showmessage($LANG['illegal_operation']);

if(!$MOD['ischecklogin'] && !$_userid) showmessage($LANG['guest_not_allowed_comment'], 'goback');
if(isset($replycid) && $replycid>0 && !$_userid && !$MOD['ischeckreply']) showmessage($LANG['guest_not_allowed_reply'], 'goback');

if(!isset($checkcodestr)) $checkcodestr = '';
checkcode($checkcodestr, $MOD['enablecheckcode'], $PHP_REFERER);

if(strlen($commentcontent) < $MOD['mincontent']) showmessage($LANG['comment_content_lessthan'].$MOD['mincontent'].$LANG['chars']);
if(strlen($commentcontent) > $MOD['maxcontent'])	showmessage($LANG['comment_content_greaterthan'].$MOD['maxcontent'].$LANG['chars']);
if(substr_count($commentcontent,'[smile_')>$MOD['maxsmilenum']) showmessage($LANG['comment_max_smile_num'].$MOD['maxsmilenum'],'goback');


$enabledkey = explode(",",$MOD['enabledkey']);
$enabledkey = array_filter($enabledkey);
if(!in_array($keyid,$enabledkey))
{
	showmessage($LANG['module_not_allowed_comment'],'goback');
}
$itemid = intval($itemid);
$score = intval($score);
$score = ($score>=1 && $score<=5) ? $score : 3;

if($MOD['ischeckcomment'])
{
	$passed = 0;
	$message = $LANG['comment_success_wait_verify'];
}
else
{
	$passed = 1;
	$message = $LANG['comment_success'];
}
if(isset($replycid))
{
	$replycid = intval($replycid);
	if($replycid)
	{
		$r = $db->get_one("SELECT ip,username,content FROM ".TABLE_COMMENT." WHERE cid=".$replycid);
		if($r)
		{
			$r['ip'] = substr($r['ip'],0,strrpos($r['ip'],'.')).".*";
			$user = $r['username']? $r['username']:$r['ip'];
			$commentcontent = '[quote][blue]'.$LANG['ourmember'].'('.$user.')'.$LANG['original_comment'].':[/blue]'.$r['content'].'[/quote]'.$commentcontent;
		}
	}
}
$commentcontent = htmlspecialchars($commentcontent);
$db->query("INSERT INTO ".TABLE_COMMENT." (keyid,itemid,username,score,content,ip,addtime,passed) VALUES('$keyid','$itemid','$_username','$score','$commentcontent','$PHP_IP','$PHP_TIME','$passed')");
if($passed == 1) update_comments($keyid, $itemid, 1);

showmessage($message, $forward);
?>