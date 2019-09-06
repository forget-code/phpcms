<?php
/*
*######################################
* PHPCMS v3.00 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit('Access Denied');
$channelid = intval($channelid);
$channelid or showmessage($LANG['invalid_parameters'],$referer);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once MOD_ROOT."/include/article.class.php";
$articleid = isset($articleid) ? intval($articleid) : 0;
$art = new article($channelid);
if($articleid) $art->articleid = $articleid;

$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');

$pagesize = isset($pagesize) && $pagesize<500 ? intval($pagesize) : $PHPCMS['pagesize'];

$submenu = array(
	array("<font color=\"blue\">{$CHA['channelname']}".$LANG['homepage']."</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"red\">{$LANG['add_article']}</font>","?mod=$mod&file=$file&action=main&channelid=$channelid"),
	array("<font color=\"blue\">{$LANG['manage_article']}</font>","?mod=$mod&file=$file&action=manage&channelid=$channelid"),
	array($LANG['check_article'],"?mod=$mod&file=$file&action=manage&job=check&channelid=$channelid"),
	array($LANG['my_article'],"?mod=$mod&file=$file&action=manage&job=myitem&channelid=$channelid"),
	array($LANG['move_articles'],"?mod=$mod&file=$file&action=move&channelid=$channelid"),
	array($LANG['manage_recycle'],"?mod=$mod&file=$file&action=manage&job=recycle&channelid=$channelid"),
	array("<font color=blue>{$LANG['template_config']}</font>","?mod=$mod&file=setting&channelid=$channelid"),
	array("<font color=\"red\">{$LANG['use_tag']}</font>","?mod=$mod&file=tag&channelid=$channelid"),
	array($LANG['statistical_reports'],"?mod=$mod&file=$file&action=stats&channelid=$channelid"),
	array("<font color=\"red\">{$LANG['publish_website']}(html)</font>","?mod=$mod&file=createhtml&channelid=$channelid"),
);

$menu = adminmenu($LANG['manage_article'],$submenu);
$action = $action ? $action : 'main';
include MOD_ROOT.'/admin/'.$mod.'_'.$action.".inc.php";
?>