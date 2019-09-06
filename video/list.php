<?php
require './include/common.inc.php';
$catid = intval($catid);
$catid or showmessage($LANG['illegal_parameters'], SITE_URL);
if(!array_key_exists($catid, $CATEGORY) || $CATEGORY[$catid]['module']!=$mod) showmessage($LANG['illegal_parameters'],'goback');

$CAT = cache_read('category_'.$catid.'.php');
@extract($CAT);

$head['keywords'] = $catname;
$head['description'] = $head['title'] = $catname.'_'.$M['name'].'_'.$PHPCMS['sitename'];

if($child==1)
{
	$arrchildid = subcat('video',$catid);
	$templateid = 'category' ;
	$ttl = CACHE_PAGE_CATEGORY_TTL;
}
else
{
	$templateid = 'list';
	$ttl = CACHE_PAGE_LIST_TTL;
}
$week_time = TIME-86400*7;
$month_time = TIME-86400*30;
$day_time = TIME-86400;

header('Last-Modified: '.gmdate('D, d M Y H:i:s', TIME).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', TIME + $ttl).' GMT');
header('Cache-Control: max-age='.$ttl.', must-revalidate');

include template('video', $templateid);
cache_page($ttl);
?>