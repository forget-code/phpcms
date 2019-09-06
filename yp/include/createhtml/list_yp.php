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
	$linkurl =  linkurl(cat_url('url', $catid, 1));
	if(!$templateid) $templateid = 'category';
	$arrchildid = subcat($mod, $catid, 'list');
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
	$r = $db->get_one("SELECT count(articleid) as num FROM ".TABLE_YP_ARTICLE." WHERE catid=$catid");
	$items = $r['num'];

	$templateid = $listtemplateid ? $listtemplateid : 'category_list';
	global $pernum;
	$page = 1;
	$pagenumber = ceil($items/$maxperpage);
	$pagenumber = max($pagenumber, 1);
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
		if($page == 1)
		{
			$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid);
			file_put_contents($filename,$data);
		}
	}
	return TRUE;
}
?>