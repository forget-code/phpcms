<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once MOD_ROOT.'include/global.func.php';
require_once MOD_ROOT.'include/answer.class.php';
$answer = new answer();
$submenu = array
(
	array($LANG['answer_manage'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['check_answer'], '?mod='.$mod.'&file='.$file.'&action=manage&job=1'),
);
$menu = admin_menu($LANG['answer_manage'], $submenu);

if(!$action) $action = 'manage';

switch($action)
{
	case 'manage':
		$job = intval($job);
		if($job)
		{
			$where = "isask=0 AND status=$job";
		}
		else
		{
			$where = 'isask=0 AND status=3';
		}
		if($askid) $where .= " AND askid=$askid";
		if($username) $where .= " AND username='$username'";
		$infos = $answer->listinfo($where, 'pid DESC', $page, 20);
		include admin_tpl('answer_manage');
	break;
	
	case 'delete':
		$answer->delete($id);
		showmessage($LANG['delete_success'], "?mod=$mod&file=$file&action=manage");
	break;

	case 'check':
		$answer->check($id);
		showmessage($LANG['check_seccess'],$forward);
	break;

	case 'view':
		$info = $answer->get($id,"a.title,p.message",1);
		include admin_tpl('answer_view');
	break;
}
?>