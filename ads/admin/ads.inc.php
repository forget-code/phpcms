<?php
defined('IN_PHPCMS') or exit('Access Denied');

$page = isset($page) ? $page : 1;
$adsplaceid = (isset($adsplaceid))?$adsplaceid:0;
$ads_expired = (isset($ads_expired))?$ads_expired:0;
$referer = isset($referer) ? urldecode($referer) : '?mod='.$mod.'&file='.$file.'&action=manage&page='.$page.'&ads_expired='.$ads_expired.'&adsplaceid='.$adsplaceid;
$action = $action ? $action : 'manage';

$actionarray = array('add','edit','delete','manage','lock','view','checked');
in_array($action, $actionarray) or showmessage($LANG['illegal_move_parameters'], $referer);

require $file.'_'.$action.'.inc.php';
?>