<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('MOD_ROOT',PHPCMS_ROOT."/".$mod);

$submenu = array(
	             array($LANG['award_setting'], "?mod=$mod&file=setting"),
	             array($LANG['award_list'], "?mod=$mod&file=list"),
	             array($LANG['award_stat'], "?mod=$mod&file=stat"),
	             array($LANG['award_delete'], "?mod=$mod&file=delete"),
	       );
$menu = adminmenu($LANG['promote_award'], $submenu);

if(!@include_once(MOD_ROOT."/admin/".$file.".inc.php")) showmessage($LANG['illegal_operation']);
?>