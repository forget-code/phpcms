<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$catid = intval($catid);
if(!$catid) return FALSE;
if(!array_key_exists($catid, $CATEGORY)) return FALSE;
if(!$CATEGORY[$catid]['ishtml']) return FALSE;
$CAT = cache_read('category_'.$catid.'.php');
@extract($CAT);

$head['title'] = $catname.'-'.$CHA['channelname'].'-'.$CHA['seo_title'];
$head['keywords'] = $seo_keywords.','.$CHA['seo_keywords'];
$head['description'] = $seo_description.'-'.$CHA['seo_description'];

$position = catpos($catid);

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
if($child==1)
{
	$templateid = $templateid ? $templateid : 'category';
	$arrchildid = subcat($channelid,$catid);
    ob_start();
	include template($mod,$templateid);
	$data = ob_get_contents();
	ob_clean();
	$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid);
	$filepath = dirname($filename);
    is_dir($filepath) or dir_create($filepath);
	file_put_contents($filename,$data);
	chmod($filename, 0777);
	return TRUE;
}
else
{
	$templateid = $listtemplateid ? $listtemplateid : 'category_list';
	global $fid, $pernum;
	if(isset($fid) && isset($pernum))
	{
		$page = $fid;
		$pagenumber = $fid+$pernum;
	}
	else
	{
		$page = 1;
		$pagenumber = ceil($items/$maxperpage);
		$pagenumber = $pagenumber ? $pagenumber : 1;
	}
	for(; $page <= $pagenumber; $page++)
	{
		ob_start();
		include template($mod, $templateid);
		$data = ob_get_contents();
		ob_clean();
		$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid, $page);
		$filepath = dirname($filename);
		is_dir($filepath) or dir_create($filepath);
		file_put_contents($filename,$data);
		chmod($filename, 0777);
		if($page == 1)
		{
			$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid, 0);
			file_put_contents($filename,$data);
			chmod($filename, 0777);
		}
	}
	return TRUE;
}
?>