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
if($_CHA[htmlcreatetype]==0 || $_CHA[htmlcreatetype]==2 || !$_CAT[$catid]['cattype']) return FALSE;

$catid = intval($catid);
if(!$catid) return FALSE;

@extract($_CAT[$catid]);

$position = cat_posurl($catid);

$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

$meta_title = $catname."-".$_CHA['channelname'];
$meta_keywords = $meta_keywords.",".$_CHA['meta_keywords'];
$meta_description = $meta_description."-".$_CHA['meta_description'];

if($child==1)
{
	$templateid = $templateid ? $templateid : "category";
	$p->set_type("url");
	$p->set_catid($catid);
	$catlisturl = $p->get_listurl(1);
	$arrchildid = get_childcatlist($channelid,$catid);
    ob_start();
	include template($mod,$templateid);
	$data = ob_get_contents();
	ob_clean();
	$p->set_catid($catid);
	$p->set_type("path");
	$filename = $p->get_listurl(0);
    $f->create(dirname($filename));
	file_write($filename,$data);
	if(!$enableadd) return TRUE;
}

$r = $db->get_one("select count(*) as number from ".TABLE_ARTICLE." where status=3 and recycle=0 and catid=$catid ");
$number = $r['number'];
$pagesize = $maxperpage;
$pagenumber = ceil($number/$pagesize)+1;
$templateid = $listtemplateid ? $listtemplateid : "category_list";

for($listpage=0; $listpage<=$pagenumber; $listpage++) 
{
	if($_CHA[htmlcreatetype]==3 && $listpage>0) break;
	if($listpage==0 && $child==1) continue;
	if($_CHA[htmlcreatetype]==1 && $file!="tohtml" && $listpage>5) break;
    $page = $listpage==0 ? 1 : $listpage;
	$p->set_type("url");
	ob_start();
	include template($mod,$templateid);
	$data = ob_get_contents();
	ob_clean();
	$p->set_type("path");
    $p->set_catid($catid);
	$filename = $p->get_listurl($listpage);
	if($listpage==0) $f->create(dirname($filename));
	file_write($filename,$data);
}

return TRUE;
?>