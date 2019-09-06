<?php 
require './include/common.inc.php';
$catid = intval($catid);
$catid or showmessage($LANG['illegal_operation'], $PHP_SITEURL);
if(!array_key_exists($catid, $CATEGORY)) showmessage($LANG['not_exist_category']);
$CAT = cache_read('category_'.$catid.'.php');
@extract($CAT);
$head['title'] = $catname.'-'.$MOD['seo_keywords'];
$head['keywords'] = $seo_keywords.','.$MOD['seo_keywords'];
$head['description'] = $seo_description.'-'.$MOD['seo_description'];
$position = catpos($catid);

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
if($child==1)
{
	$cats = subcat($mod, $catid);
	$templateid = $templateid ? $templateid : 'category' ;
}
else
{
	$page = isset($page) ? intval($page) : 1;
	$templateid = $listtemplateid ? $listtemplateid : 'category_list';
}

include template($mod,$templateid);
?>