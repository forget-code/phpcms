<?php
defined('IN_PHPCMS') or exit('Access Denied');

$player = load('player.class.php');
if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
	case 'manage':
		$result = $player->listinfo();
		
		include admin_tpl('player_manage');
	break;
	case 'add':
		if($dosubmit)
		{
		
			$playerid = $player->add($info);
			if(!$playerid)
			{
				showmessage('操作失败', $forward);
			}
			showmessage('添加成功', $forward);
		}
		else
		{
			include admin_tpl('player_add');
		}
	break;
	case 'edit':
		if($dosubmit)
		{
			$playerid = $player->edit($playerid, $info);
			if(!$playerid)
			{
				showmessage('操作失败', $forward);
			}
			showmessage('修改成功', $forward);
		}
		else
		{
			$info = $player->get($playerid);
			@extract($info);
			include admin_tpl('player_edit');
		}
	break;
	case 'disabled':
		$player->disabled($playerid, $disabled);
		showmessage('修改成功', $forward);
	break;
	case 'delete':
		$player->delete($playerid);
		showmessage('删除成功', $forward);
	break;
	case 'checkname':

	break;
}
?>