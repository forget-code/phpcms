<?php
defined('IN_PHPCMS') or exit('Access Denied');
$catid = intval($catid);
if(!$catid) return FALSE;
$head['title'] = $catname.'-'.$MOD['seo_keywords'];
$head['keywords'] = $seo_keywords.','.$MOD['seo_keywords'];
$head['description'] = $seo_description.'-'.$MOD['seo_description'];
$position = catpos($catid);
$TYPE = cache_read('yp_article_cat.php');
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;

	$r = $db->get_one("SELECT count(articleid) as num FROM ".TABLE_YP_ARTICLE." WHERE catid=$catid");
	$items = $r['num'];

	$templateid = 'article_list';
	global $pernum;
	$page = 1;
	$pagenumber = ceil($items/$MOD['pagesize']);
	$pagenumber = max($pagenumber, 1);
	for(; $page <= $pagenumber; $page++)
	{
		ob_start();
		include template($mod, $templateid);
		$data = ob_get_contents();
		ob_clean();
		$filename = PHPCMS_ROOT.'/'.article_cat_url($catid, $page);
		$filepath = dirname($filename);
		is_dir($filepath) or dir_create($filepath);
		file_put_contents($filename,$data);
		if($page == 1)
		{
			$filename = PHPCMS_ROOT.'/yp/'.$MOD['article_dir'].'/'.$TYPE[$catid]['type'].'-'.$TYPE[$catid]['typeid'].'.'.$PHPCMS['fileext'];
			file_put_contents($filename,$data);
		}
	}
	return TRUE;
?>