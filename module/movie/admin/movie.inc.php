<?php
defined('IN_PHPCMS') or exit('Access Denied');
$channelid = intval($channelid);
$channelid or showmessage($LANG['illegal_parameters'],$referer);
require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();
require_once MOD_ROOT."/include/movie.class.php";
$movieid = isset($movieid) ? intval($movieid) : 0;
$d = new movie($channelid);
if($movieid) $d->movieid = $movieid;
$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');
$pagesize = isset($pagesize) && $pagesize<500 ? intval($pagesize) : $PHPCMS['pagesize'];
$submenu = array(
	array("<font color=\"blue\">{$CHA['channelname']}".$LANG['home']."</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['add_movie']."</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"blue\">".$LANG['manage_movie']."</font>","?mod=$mod&file=$file&action=manage&channelid=$channelid"),
	array($LANG['check_movie'],"?mod=$mod&file=$file&action=manage&job=check&channelid=$channelid"),
	array($LANG['my_add'],"?mod=$mod&file=$file&action=manage&job=myitem&channelid=$channelid"),
	array($LANG['moves_batch_movie'],"?mod=$mod&file=$file&action=move&channelid=$channelid"),
	array($LANG['recycle_bin_management'],"?mod=$mod&file=$file&action=manage&job=recycle&channelid=$channelid"),
	array("<font color=blue>".$LANG['mold_installs']."</font>","?mod=$mod&file=setting&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['label_to_use']."</font>","?mod=$mod&file=tag&channelid=$channelid"),
	array($LANG['statistics_statement'],"?mod=$mod&file=$file&action=stats&channelid=$channelid"),
	array("<font color=\"red\">".$LANG['issued_homepage']."</font>","?mod=$mod&file=createhtml&channelid=$channelid"),
);
$menu = adminmenu($LANG['manage_movie'],$submenu);
$action = $action ? $action : 'main';
include MOD_ROOT.'/admin/'.$mod.'_'.$action.".inc.php";
?>