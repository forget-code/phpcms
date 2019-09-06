<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$MOD['createlistinfo']) return false;
$infocat = $tab= intval($infocat);
if(!$infocat) return false;
$infotypename = $PARS['infotype']['type_'.$infocat];
if($infocat<1 || $infocat>6) return false;

$head['title'] = $PARS['infotype']['type_'.$infocat].'-'.$MOD['seo_keywords'];
$head['keywords'] = $PARS['infotype']['type_'.$infocat].'-'.$MOD['seo_keywords'];
$head['description'] =  $PARS['infotype']['type_'.$infocat].'-'.$MOD['seo_description'];

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$page = isset($page) ? intval($page) : 1;
$templateid = 'listinfo';


$r = $db->get_one("Select count(houseid) as hcount FROM ".TABLE_HOUSE." WHERE infocat=$infocat AND status=1");
$items = $r['hcount'];

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
	$filename = PHPCMS_ROOT.'/'.house_list_url('path', $infocat, $page);
	$filepath = dirname($filename);
	is_dir($filepath) or dir_create($filepath);
	file_put_contents($filename,$data);
	chmod($filename, 0777);
	if($page == 1)
	{
		$filename = PHPCMS_ROOT.'/'.house_list_url('path', $infocat, 0);
		file_put_contents($filename,$data);
		chmod($filename, 0777);
	}
}
return TRUE;
?>