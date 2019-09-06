<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$MOD['createlistdisplay']) return false;
$tab = 'listdisplay';
$areaid = 0;

$head['title'] = '新楼盘-'.$MOD['seo_keywords'];
$head['keywords'] = '新楼盘列表-'.$MOD['seo_keywords'];
$head['description'] =  '新楼盘列表-'.$MOD['seo_description'];

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = 'listdisplay';
$page = isset($page) ? intval($page) : 1;

$r = $db->get_one("Select count(displayid) as dcount FROM ".TABLE_HOUSE_DISPLAY." WHERE status=1");
$items = $r['dcount'];

$pagenumber = ceil($items/$MOD['pagesize']);

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

for(; $page <= $pagenumber; $page++)
{
	ob_start();
	include template($mod, $templateid);
	$data = ob_get_contents();
	ob_clean();
	$filename = PHPCMS_ROOT.'/'.display_list_url('path', $page);
	$filepath = dirname($filename);
	is_dir($filepath) or dir_create($filepath);
	file_put_contents($filename,$data);
	chmod($filename, 0777);
	if($page == 1)
	{
		$filename = PHPCMS_ROOT.'/'.display_list_url('path');
		file_put_contents($filename,$data);
		chmod($filename, 0777);
	}
}
return TRUE;
?>