<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$catid = intval($catid);
if(!$catid) return FALSE;
if(!isset($CATEGORY[$catid])) return FALSE;
if(!$CATEGORY[$catid]['ishtml']) return FALSE;
$CAT = isset($TEMP['cat'][$catid]) ? $TEMP['cat'][$catid] : $TEMP['cat'][$catid] = cache_read('category_'.$catid.'.php');
@extract($CAT);

$head['title'] = $seo_title ? $catname.'-'.$seo_title : $catname.'-'.$CHA['channelname'].'-'.$CHA['seo_title'];
$head['keywords'] = $seo_keywords.','.$CHA['seo_keywords'];
$head['description'] = $seo_description.'-'.$CHA['seo_description'];

$position = isset($TEMP['catpos'][$catid]) ? $TEMP['catpos'][$catid] : $TEMP['catpos'][$catid] = catpos($catid);

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
if($child == 1)
{
	$linkurl =  linkurl(cat_url('url', $catid, 1));
	if(!$templateid) $templateid = 'category';
	$arrchildid = subcat($channelid, $catid, 'list');
	$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid);
	$filepath = dirname($filename);
    is_dir($filepath) or dir_create($filepath);
    ob_start();
	include template($mod,$templateid);
	$data = ob_get_contents();
	ob_clean();
	file_put_contents($filename, $data);
	@chmod($filename, 0777);
	if(!$enableadd) return TRUE;
}
else
{
	$indexname = PHPCMS_ROOT.'/'.cat_url('path', $catid, 0);
	$filepath = dirname($indexname);
	is_dir($filepath) or dir_create($filepath);
}

$templateid = $listtemplateid ? $listtemplateid : 'category_list';
$pagenumber = ceil($items/$maxperpage);
$pagenumber = $pagenumber ? $pagenumber : 1;
if(isset($fid) && isset($pernum))
{
	$page = $fid;
	$topage = $fid+$pernum;
	$pagenumber = $topage <= $pagenumber ? $topage : $pagenumber;
}
else
{
	$page = 1;
}

for($n = $page; $n <= $pagenumber; $n++)
{
	$filenames[$n] = PHPCMS_ROOT.'/'.cat_url('path', $catid, $n);
}

for(; $page <= $pagenumber; $page++)
{
	ob_start();
	include template($mod, $templateid);
	$data = ob_get_contents();
	ob_clean();
	$filename = $filenames[$page];
	file_put_contents($filename,$data);
	@chmod($filename, 0777);
	if($page == 1 && !$child)
	{
		copy($filename, $indexname);
		@chmod($indexname, 0777);
	}
}
return TRUE;
?>