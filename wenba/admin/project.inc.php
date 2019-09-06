<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['manage_member_actor'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_member_actor'], '?mod='.$mod.'&file='.$file.'&action=add'),
);
$curUri = "?$PHP_QUERYSTRING";
$menu=adminmenu($LANG['manage_member_actor'], $submenu);

$action = $action ? $action : 'manage';
switch($action)
{
	case 'manage':
	$TYPES = explode("\n", $MOD['vote_give_actor']);
	$page = $page ? intval($page) : 1;
	$pagesize = 30;
	$number = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_WENBA_ACTOR."");
	$pages = phppages($number['num'], $page, $pagesize);
	$offset = ($page-1)*$pagesize;
	$actors = array();
	$result = $db->query("SELECT * FROM ".TABLE_WENBA_ACTOR." ORDER BY typeid ASC, id DESC LIMIT $offset, $pagesize");
	while ($r = $db->fetch_array($result))
	{
		$actors[] = $r;
	}
	include admintpl("project_list");
	break;

	case 'add':
	if($dosubmit)
	{
		if(isset($actors) && is_array($actors))
		{
			foreach($actors as $key => $value)
			{
				$db->query("INSERT INTO ".TABLE_WENBA_ACTOR." (typeid, grade, actor, min, max) VALUES ('$typeid', '$grade[$key]', '$actors[$key]', $min[$key], $max[$key])");
			}
			$actor_arr = array();
			$result = $db->query("SELECT * FROM ".TABLE_WENBA_ACTOR." WHERE typeid=$typeid ORDER BY id ASC");
			while($r = $db->fetch_array($result))
			{
				$actor_arr[] = $r;
			}
			$arr = cache_read('actors.php');
			$arr[$typeid] = $actor_arr;
			cache_write('actors.php', $arr);
			showmessage($LANG['add_success'], "?mod=$mod&file=$file&action=manage");
		}
		else
		{
			include admintpl("project_add-1");
		}
	}
	else
	{
		$type_selected = "<select name='member_actor'><option value=''></option>";
		$member_actors = explode("\n",$MOD['vote_give_actor']);
		foreach($member_actors AS $i => $t)
		{
			$type_selected .= "<option value='".intval($i)."'>$t</option>";
		}
		$type_selected .= "</select>";
		include admintpl("project_add");
	}	
	break;

	case 'delete':
	if(is_array($id))
	{
		if(count($id)==0) showmessage($LANG['illegal_operation'], $PHP_REFERER); 
		foreach($id as $value)
		{
			$value = intval($value);
			$db->query("DELECT FROM ".TABLE_WENBA_ACTOR." WHERE id=$value");
		}
	}
	else 
	{
		$id = intval($id);
		if(!$id) showmessage($LANG['illegal_operation'], $PHP_REFERER);
		$db->query("DELETE FROM ".TABLE_WENBA_ACTOR." WHERE id=$id");
	}
	$actor_arr = array();
	$result = $db->query("SELECT * FROM ".TABLE_WENBA_ACTOR." WHERE typeid=$typeid ORDER BY id ASC");
	while($r = $db->fetch_array($result))
	{
		$actor_arr[] = $r;
	}
	$arr = cache_read('actors.php');
	$arr[$typeid] = $actor_arr;
	cache_write('actors.php', $arr);
	showmessage($LANG['delete_success'], $PHP_REFERER);
    break;

	case 'edit':
	if($dosubmit)
	{
		$db->query("UPDATE ".TABLE_WENBA_ACTOR." SET grade='$grade', actor='$actor', min=$min, max=$max WHERE id=$id");
		$actors = array();
		$actors = cache_read('actors.php');
		$result = $db->query("SELECT * FROM ".TABLE_WENBA_ACTOR." WHERE typeid=$type ORDER BY id ASC");
		while($r = $db->fetch_array($result))
		{
			$actors[$type][] = $r;
		}
		cache_write('actors.php', $actors);
		showmessage($LANG['update_success'], "?mod=$mod&file=$file&action=manage");
	}
	else
	{
		$id = intval($id);
		if(!$id) showmessage($LANG['illegal_operation'], $PHP_REFERER);
		$r = $db->get_one("SELECT * FROM ".TABLE_WENBA_ACTOR." WHERE id=$id");
		@extract($r);
		$TYPES = explode("\n", $MOD['vote_give_actor']);
		$type_selected = "<select name='member_actor' disabled><option value=''></option>";
		$member_actors = explode("\n",$MOD['vote_give_actor']);
		foreach($member_actors AS $i => $t)
		{
			$select = '';
			if($i==$typeid) $select .= 'selected'; 
			$type_selected .= "<option value='".intval($i)."' ".$select.">$t</option>";
		}
		$type_selected .= "</select>";
		include admintpl('project_edit');
	}
}
?>