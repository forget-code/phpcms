<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('MOD_ROOT', PHPCMS_ROOT.'/'.$mod);

require MOD_ROOT.'/include/global.func.php';

$module  = $mod;
$submenu = array(
				array('<font color="red">'.$LANG['add_advertisement'].'</font>','?mod='.$mod.'&file=adsplace&action=add&catid='.$catid),
				array($LANG['manage_advertisement'],'?mod='.$mod.'&file=adsplace&action=manage'),
				array($LANG['manage_the_order_of_advertisement'],'?mod='.$mod.'&file=ads&action=manage'),
				array($LANG['update_html_and_js'],'?mod='.$mod.'&file=createhtml'),
	       );
$menu = adminmenu($LANG['advertising_management'],$submenu);
if(!@include_once(MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>