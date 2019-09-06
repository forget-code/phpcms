<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade > 0) $action = 'my';

require PHPCMS_ROOT.'/include/menu.inc.php';

function position_select($name = 'position', $position = '', $property = '')
{
	global $POSITION;
	$select = '';
	foreach($POSITION as $k=>$v)
	{
		$select .= '<option value="'.$k.'" '.($k == $position ? 'selected' : '').'>'.$v.'</option>';
	}
	return '<select name="'.$name.'" '.$property.'>'.$select.'</select>';
}

function target_select($name = 'target', $target = '', $property = '')
{
	global $TARGET;
	$select = '';
	foreach($TARGET as $k=>$v)
	{
		$select .= '<option value="'.$k.'" '.($k == $target ? 'selected' : '').'>'.$v.'</option>';
	}
	return '<select name="'.$name.'" '.$property.'>'.$select.'</select>';
}

$submenu = array
(
	array($LANG['add_menu'], '?mod='.$mod.'&file='.$file.'&action=add'),
	array($LANG['manage_menu'], '?mod='.$mod.'&file='.$file.'&action=manage'),
);
$menu = adminmenu($LANG['nav_menu_manage'], $submenu);

$actions = array('add','edit','manage','my');
if(!in_array($action, $actions)) $action = 'manage';
include PHPCMS_ROOT.'/admin/action/menu_'.$action.'.inc.php';
?>