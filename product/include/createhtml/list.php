<?php
defined('IN_PHPCMS') or exit('Access Denied');

$catid = intval($catid);
if(!$catid) return FALSE;
if(!array_key_exists($catid, $CATEGORY)) return FALSE;
if(!$CATEGORY[$catid]['ishtml']) return FALSE;
$CAT = cache_read('category_'.$catid.'.php');
@extract($CAT);

$head['title'] = $catname.'-'.$MOD['seo_keywords'];
$head['keywords'] = $seo_keywords.','.$MOD['seo_keywords'];
$head['description'] = $seo_description.'-'.$MOD['seo_description'];

$position = catpos($catid);

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
if($child==1)
{
	$templateid = $templateid ? $templateid : "category";
	$cats = subcat($mod, $catid);
    ob_start();
	include template($mod,$templateid);
	$data = ob_get_contents();
	ob_clean();
	$filename = PHPCMS_ROOT.'/'.cat_url('url', $catid);
	$filepath = dirname($filename);
    is_dir($filepath) or dir_create($filepath);
	file_put_contents($filename,$data);
	return TRUE;
}
else
{	

	$r = $db->get_one("SELECT count(productid) as num FROM ".TABLE_PRODUCT." WHERE catid=$catid");
	$items = $r['num'];

	$templateid = $listtemplateid ? $listtemplateid : 'category_list';
	global $pernum;
	$page = 1;
	$pagenumber = ceil($items/$maxperpage);
	$pagenumber = max($pagenumber, 1);
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
		
		$filepath = dirname($filename);
		is_dir($filepath) or dir_create($filepath);
		file_put_contents($filename,$data);
		if($page == 1)
		{
			$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid);
			file_put_contents($filename,$data);
		}
	}
	return TRUE;
}
?>