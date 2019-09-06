<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'include/global.func.php';
require_once MOD_ROOT.'include/ask.class.php';
require_once MOD_ROOT.'include/output.func.php';

$ask = new ask();
$submenu = array
(
	array($LANG['all_question'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['waiting_solve'], '?mod='.$mod.'&file='.$file.'&action=manage&job=3'),
	array($LANG['solove_question'], '?mod='.$mod.'&file='.$file.'&action=manage&job=5'),
	array($LANG['vote_question'], '?mod='.$mod.'&file='.$file.'&action=manage&flag=1'),
	array($LANG['elite_question'], '?mod='.$mod.'&file='.$file.'&action=manage&flag=3'),
	array($LANG['close_question'], '?mod='.$mod.'&file='.$file.'&action=manage&job=6'),
	array($LANG['overdue_question'], '?mod='.$mod.'&file='.$file.'&action=manage&passed=1'),
	array("<font color='#FF0000'>".$LANG['check_question']."</font>", '?mod='.$mod.'&file='.$file.'&action=manage&job=1'),
	array($LANG['move_question'], '?mod='.$mod.'&file='.$file.'&action=move'),
	array('删除问题', '?mod='.$mod.'&file='.$file.'&action=advancedelete'),
);
$menu = admin_menu($LANG['question_manage'], $submenu);

if(!$action) $action = 'manage';

switch($action)
{
	case 'manage':
		if(isset($job))
		{
			$job = intval($job);
			$where = "status='$job'";
		}
		else if(isset($flag))
		{
			$where = "flag='$flag'";
		}
		else
		{
			$where = '1';
		}
		if($username) $where .= " AND `username` LIKE '%$username%'";
		if($search) $where .= " AND title like '%$keywords%'";
		if($catid) $where .= " AND catid=$catid";
		if($passed) $where .= " AND endtime<".TIME;
		$infos = $ask->listinfo($where, 'askid DESC', $page, 20);
		if(isset($job) && $job==1)
		{
			$tpl_job = 'check';
		}
		else
		{
			$tpl_job = 'manage';
		}
		include admin_tpl('ask_'.$tpl_job);
	break;
	
	case 'delete':
		$ask->delete($id);
		showmessage($LANG['delete_success'], "?mod=$mod&file=$file&action=manage");
	break;

	case 'advancedelete':
		if($dosubmit)
		{
			$where = '';
			if($addtime) $addtime = strtotime($addtime);
			if($endtime) $endtime = strtotime($endtime);
			if($username) $where .= " `username`='$username'";
			if($addtime && !$endtime) $where .= ($where) ? " AND `addtime`>$addtime" : " `addtime`>$addtime";
			if($endtime && !$addtime) $where .= ($where) ? " AND `endtime`<$endtime" : " `endtime`<$endtime";
			if($addtime && $endtime) $where .= ($where) ? " AND `addtime`>$addtime AND `endtime`<$endtime": " `addtime`>$addtime AND `endtime`<$endtime";
			if($ischeck) $where .= " AND `ischeck`='$ischeck'";
			if(!$where) showmessage('请选择删除条件', $forward);
			$result = $ask->listinfo($where);
			if($result)
			{
				foreach($result as $item)
				{
					$ask->delete($item['askid']);
				}
			}
			showmessage($LANG['delete_success'], "?mod=$mod&file=$file&action=manage");
		}
		else
		{
			include admin_tpl('ask_advancedelete');
		}
	break;

	case 'check':
		$ask->check($id);
		showmessage($LANG['check_seccess'], $forward);
	break;

	case 'move':
		if(isset($ids) && $targetcatid)
		{
			if($targetcatid=='') showmessage('目标栏目不能为空',$forward);
			if(!$fromtype)
			{
				if(empty($ids)) showmessage('指定的ID不能为空');
				if(!preg_match("/^[0-9]+(,[0-9]+)*$/",$ids)) showmessage($LANG['illegal_parameters']);
				$ask->move($ids,$targetcatid,$fromtype);
			}
			else
			{
				$ask->move($batchcatid,$targetcatid,$fromtype);
			}
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$ids = is_array($id) ? implode(',',$id) : $id;
			$category_select = form::select_category($mod, 0);
			$category_select = str_replace(array("<select name='catid' id='catid' >","<option value='0'></option>"),'',$category_select);
			include admin_tpl('ask_move');
		}
	break;

	case 'view':
		$info = $ask->detail($id,'*',1);
		include admin_tpl('ask_view');
	break;

	case 'elite':
		if(is_array($id))
		{
			if($flag)
			{
				$flag = 3;
			}
			else
			{
				$flag = 0;
			}
			foreach($id AS $askid)
			{
				$ask->flag($askid, $flag);
			}
		}
		showmessage($LANG['operation_success'], $forward);
	break;
}
?>