<?php
defined('IN_PHPCMS') or exit('Access Denied');

isset($typeid) or showmessage('非法信息ID参数');
$module = $mod;
$infotypename = $PARS['infotype']['type_'.$typeid];

$submenu = array(
	array('已审核'.$infotypename.'信息', '?mod='.$mod.'&file='.$file.'&typeid='.$typeid.'&action=manage'),
	array('待审核'.$infotypename.'信息', '?mod='.$mod.'&file='.$file.'&typeid='.$typeid.'&action=manage&status=0'),
	array('过期'.$infotypename.'信息', '?mod='.$mod.'&file='.$file.'&typeid='.$typeid.'&action=manage&overdue=1'),
	);
$extramenu = array(
	array("添加".$infotypename,PHPCMS_PATH."house/frontmgr.php?type=$typeid&action=add"),	
	);
$menu = adminmenu($infotypename.'信息管理', $submenu, $extramenu);

$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('add','edit','delete','manage','view','changestatus','print');
in_array($action,$filearray) or showmessage($LANG['illegal_action'], $referer);

require $file.'_'.$action.'.inc.php';
?>