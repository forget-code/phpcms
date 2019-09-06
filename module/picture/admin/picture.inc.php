<?php

defined('IN_PHPCMS') or exit('Access Denied');

$channelid = intval($channelid);
$channelid or showmessage($LANG['illegal_parameters'],$referer);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once MOD_ROOT."/include/picture.class.php";
$pictureid = isset($pictureid) ? intval($pictureid) : 0;
$pic = new picture($channelid);
if($pictureid) $pic->pictureid = $pictureid;

$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');

$pagesize = isset($pagesize) && $pagesize<500 ? intval($pagesize) : $PHPCMS['pagesize'];

$submenu = array(
	array("<font color=\"blue\">{$CHA['channelname']}".$LANG['index']."</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['add_picture']."</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"blue\">".$LANG['manage_picture']."</font>","?mod=$mod&file=$file&action=manage&channelid=$channelid"),
	array($LANG['approval_picture'],"?mod=$mod&file=$file&action=manage&job=check&channelid=$channelid"),
	array($LANG['my_picture'],"?mod=$mod&file=$file&action=manage&job=myitem&channelid=$channelid"),
	array($LANG['batch_move_picture'],"?mod=$mod&file=$file&action=move&channelid=$channelid"),
	array($LANG['recycle_manage'],"?mod=$mod&file=$file&action=manage&job=recycle&channelid=$channelid"),
	array("<font color=\"blue\">".$LANG['module_setting']."</font>","?mod=$mod&file=setting&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['label_invoke']."</font>","?mod=$mod&file=tag&channelid=$channelid"),
	array($LANG['report_form'],"?mod=$mod&file=$file&action=stats&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['publish_html']."</font>","?mod=$mod&file=createhtml&channelid=$channelid"),
);

$menu = adminmenu($LANG['picture_manage'],$submenu);
$action = $action ? $action : 'main';
include MOD_ROOT.'/admin/'.$mod.'_'.$action.".inc.php";
?>