<?php
defined('IN_PHPCMS') or exit('Access Denied');
include(PHPCMS_ROOT."/$mod/admin/menu.inc.php");

$action = !empty($action) ? $action : 'manage';
$submenu = array
(
	array($LANG['manage_answer'], '?mod='.$mod.'&file='.$file.'&action=manage')
);
$menu = adminmenu($LANG['manage_answer'],$submenu);



switch($action)
{
	case 'manage':
		$qid = isset($qid) ? intval($qid) : '';
		$username = isset($username) ? trim($username) : '';
		if($qid && $username)
		{
			$sql = " WHERE qid='$qid' AND username LIKE '%$username%'";
		}
		elseif(!$qid && $username)
		{
			$sql = " WHERE username LIKE '%$username%'";
		}
		elseif($qid && !$username)
		{
			$sql = " WHERE qid='$qid'";	
		}
		else
		{
			$sql = null;
		}
		$row = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_WENBA_ANSWER." $sql");
		extract($row);
		$total = $num;
		if ($total)
		{
			$pagesize = 20;
			$page = intval($page);
			if($page < 1) $page=1;	
			$offset = ($page - 1) * $pagesize;
			$taday = date("Y-m-d");
			$res = $db->query("SELECT aid,qid,username,answer,answertime,accept_status FROM ".TABLE_WENBA_ANSWER." $sql LIMIT $offset,$pagesize");
			while ($r = $db->fetch_array($res))
			{	
				$r['answertime'] = date('Y-m-d H:i',$r['answertime']);
				$r['answer'] = str_cut($r['answer'],50);
				$answer_list[] = $r;
			}
			$phpcmspage = phppages($total, $page, $pagesize);
			$referer = "$curUri&page=$page";
		}
	break;

	case 'delete':
		if ($dosubmit)
		{	
			$item = is_array($aid) ? implode(',',$aid) : intval($aid);
			
			if (isset($remove))
			{
				$db->query("DELETE FROM ".TABLE_WENBA_ANSWER." WHERE aid IN ($item)");
			}
			showmessage($LANG['operation_success'], $PHP_REFERER);
		}
	break;
}
include admintpl('answer');
?>