<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$catid = intval($catid);
$catid or showmessage($LANG['illegal_operation'],$PHP_SITEURL);
if(!array_key_exists($catid, $CATEGORY)) showmessage($LANG['sorry_not_exist_category'],'goback');
$CAT = cache_read('category_'.$catid.'.php');

@extract($CAT);

$head['title'] = $seo_title ? $catname.'-'.$seo_title : $catname.'-'.$CHA['channelname'].'-'.$CHA['seo_title'];
$head['keywords'] = $seo_keywords.','.$CHA['seo_keywords'];
$head['description'] = $seo_description.'-'.$CHA['seo_description'];

$position = catpos($catid);

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
if($child==1)
{
	$linkurl =  linkurl(cat_url('url', $catid, 1));
	$arrchildid = subcat($channelid, $catid, 'list');
	$templateid = $templateid ? $templateid : 'category' ;
}
else
{	
	$page = isset($page) ? intval($page) : 1;
	$templateid = $listtemplateid ? $listtemplateid : 'category_list';
}
include template($mod,$templateid);
if(!$enablepurview) phpcache();
?>