<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if(!$CHA['ishtml']) return FALSE;

$specialid = intval($specialid);
if($specialid < 1) showmessage($LANG['illegal_operation']);

$special = $spe->get_info($specialid);
if(!$special) showmessage($LANG['specail_topic_not_exist']);

if($special['parentid'] > 0 || $special['arrchildid'] == '')
{
	$subspecialid = $specialid;
    $subspecialname = $special['specialname'];
	$sublinkurl = $special['linkurl'];
	$special = $spe->get_info($special['parentid']);
	unset($special['specialid']);
	$special['linkurl'] = linkurl($special['linkurl']);
    $position = '<a href="'.$special['linkurl'].'">'.$special['specialname'].'</a> >> '.$subspecialname;
}
else
{
	$subspecialid = 0;
    $position = $special['specialname'];
}

extract($special);

$specialpic = imgurl($specialpic);
if($specialbanner) $specialbanner = imgurl($specialbanner);

$head['title'] = $seo_title ? $seo_title : $specialname;
$head['keywords'] = $seo_keywords;
$head['description'] = $seo_description;

$filename = PHPCMS_ROOT.'/'.special_showurl('path',$specialid,$addtime,$prefix);
dir_create(dirname($filename));

if(!$templateid) $templateid = 'special_show';

ob_start();
include template($module, $templateid);
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, $data);
return TRUE;
?>