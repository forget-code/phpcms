<?php
require './include/common.inc.php';
require_once PHPCMS_ROOT.'/yp/include/global.func.php';

$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
unset($arrchildid);
$catid = intval($catid);
$catid or showmessage($LANG['invalid_parameters'], $PHP_SITEURL);
if(!array_key_exists($catid, $CATEGORY)) showmessage($LANG['invalid_category'],'goback');
$CAT = cache_read('category_'.$catid.'.php');
@extract($CAT);

if($enablepurview)
{
	if(!check_purview($arrgroupid_browse)) showmessage($LANG['category_for_hidden']);
}

$position = catpos($catid);

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
if($child==1)
{
	$linkurl =  linkurl(cat_url('url', $catid, 1));
	$arrchildid = subcat($mod, $catid, 'list');
	$templateid = $templateid ? $templateid : 'category';
}
else
{
	$page = isset($page) ? intval($page) : 1;
	$templateid = 'category_list';
}
include template($mod,$templateid);
if(!$enablepurview) phpcache();
?>