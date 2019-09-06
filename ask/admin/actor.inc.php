<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/actor.class.php';
$actor = new actor();
$submenu = array
(
	array($LANG['actor_manage'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_actor'], '?mod='.$mod.'&file='.$file.'&action=add'),
);
$menu = admin_menu($LANG['actor_manage'], $submenu);

if(!$action) $action = 'manage';

switch($action)
{
	case 'manage':
		$infos = $actor->listinfo('', 'id', 1, 50);
		$TYPES = explode("\n", $M['member_group']);
		include admin_tpl('actor_manage');
	break;
	
	case 'delete':
		$actor->delete($id);
		showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=manage");
	break;

	case 'add':
		if($dosubmit)
		{
			if(isset($typeid) && is_array($grade))
			{
				$actor_array = array();
				$actor_array['typeid'] = $typeid;
				foreach($actors as $key => $value)
				{
					if(!trim($grade[$key])) continue;
					$actor_array['grade'] = $grade[$key];
					$actor_array['actor'] = $actors[$key];
					$actor_array['min'] = $min[$key];
					$actor_array['max'] = $max[$key];
					$actor->add($actor_array);
				}
				
				showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=manage");
			}
			else
			{
				include admin_tpl("actor_add_next");
			}
		}
		else
		{
			$member_actors = explode("\n",$M['member_group']);
			$type_selected = form::select($member_actors,'typeid');
			include admin_tpl("actor_add");
		}
	break;

	case 'edit':
		if($dosubmit)
		{
			$actor->edit($id,$info);
			showmessage($LANG['update_success'], "?mod=$mod&file=$file&action=manage");
		}
		else
		{
			$id = intval($id);
			if(!$id) showmessage($LANG['illegal_operation'], $forward);
			$r = $db->get_one("SELECT * FROM ".DB_PRE."ask_actor WHERE id=$id");
			@extract($r);
			$member_actors = explode("\n",$M['member_group']);
			$type_selected = form::select($member_actors,'info[typeid]','',$typeid);
			include admin_tpl('actor_edit');
		}
}
?>