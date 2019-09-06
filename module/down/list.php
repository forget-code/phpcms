<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
defined('IN_PHPCMS') or exit('Access Denied');
include PHPCMS_ROOT."/module/down/common.php";

$catid = intval($catid);
if(!is_array($_CAT[$catid])) message('栏目不存在，请返回','goback');

@extract($_CAT[$catid]);

if($catpurview)
{
	if(!check_purview($arrgroupid_browse))
	{
		message("本栏目为认证栏目，您没有权限浏览！","goback");
	}
}

$position = cat_posurl($catid); 

$p->set_catid($catid);
if($child && $page==0) $catlisturl = $p->get_listurl(1);
$arrchildid = get_childcatlist($channelid,$catid);

$page = intval($page);

$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;
$cattemplateid = ($child && !$page)  ? $templateid : $listtemplateid;
$templatetype = ($child && !$page)  ? 'category' : 'category_list';
$templateid = $cattemplateid ? $cattemplateid : $templatetype;

$page = $page ? $page : 1 ;

$meta_title = $catname."-".$_CHA['channelname'];
$meta_keywords = $meta_keywords.",".$_CHA['meta_keywords'];
$meta_description = $meta_description."-".$_CHA['meta_description'];

if(!$catpurview) $filecaching = 1;

include template($mod,$templateid);
?>