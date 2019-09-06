<?php
defined('IN_PHPCMS') or exit('Access Denied');

$channelid = intval($channelid);
$channelid or showmessage($LANG['illegal_parameters'],$referer);
require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once MOD_ROOT."/include/down.class.php";
$downid = isset($downid) ? intval($downid) : 0;
$d = new down($channelid);
if($downid) $d->downid = $downid;

$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');

$pagesize = isset($pagesize) && $pagesize<500 ? intval($pagesize) : $PHPCMS['pagesize'];

$submenu = array(
	array("<font color=\"blue\">{$CHA['channelname']}".$LANG['home']."</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['add_download']."</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"blue\">".$LANG['management_download']."</font>","?mod=$mod&file=$file&action=manage&channelid=$channelid"),
	array($LANG['examine_download'],"?mod=$mod&file=$file&action=manage&job=check&channelid=$channelid"),
	array($LANG['my_add'],"?mod=$mod&file=$file&action=manage&job=myitem&channelid=$channelid"),
	array($LANG['moves_batch_downkload'],"?mod=$mod&file=$file&action=move&channelid=$channelid"),
	array($LANG['recycle_bin_management'],"?mod=$mod&file=$file&action=manage&job=recycle&channelid=$channelid"),
	array("<font color=blue>".$LANG['mold_installs']."</font>","?mod=$mod&file=setting&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['label_to_use']."</font>","?mod=$mod&file=tag&channelid=$channelid"),
	array($LANG['statistics_statement'],"?mod=$mod&file=$file&action=stats&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['issued_homepage']."</font>","?mod=$mod&file=createhtml&channelid=$channelid"),
);

$menu = adminmenu($LANG['management_download'],$submenu);
$action = $action ? $action : 'main';
include MOD_ROOT.'/admin/'.$mod.'_'.$action.".inc.php";
?>