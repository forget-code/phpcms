<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$types = cache_read('freelink_type.php');
$submenu[0] = array($LANG['type_manage'], '?mod='.$mod.'&file='.$file.'&action=type');
foreach($types as $k=>$v)
{
	$submenu[] = array($k, '?mod='.$mod.'&file='.$file.'&action=manage&type='.urlencode($k));
}
$menu = adminmenu($LANG['freelink_manage'], $submenu);
$actions = array('type','update','manage','preview','delete');
if(!in_array($action, $actions)) $action = 'type';
include PHPCMS_ROOT.'/admin/action/'.$file.'_'.$action.'.inc.php';
?>