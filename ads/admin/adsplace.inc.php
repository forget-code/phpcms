<?php
defined('IN_PHPCMS') or exit('Access Denied');

$page = (isset($page))?$page:1;
$referer = isset($referer) ? urldecode($referer) : '?mod='.$mod.'&file='.$file.'&action=manage&page='.$page;
$action=$action ? $action : 'manage';

$actionarray = array('add','edit','delete','manage','lock','loadjs','view');
in_array($action,$actionarray) or showmessage($LANG['illegal_move_parameters'],$referer);

require $file."_".$action.".inc.php";

?>