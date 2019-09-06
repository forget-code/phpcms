<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
require PHPCMS_ROOT.'/admin/include/special.class.php';

$specialid = intval($specialid);
if($specialid < 1) showmessage($LANG['illegal_parameters']);

$spe = new special($channelid, $specialid);
$special = $spe->get_info();
if(!$special) showmessage($LANG['specail_topic_not_exist']);

if($special['parentid'] > 0 || $special['arrchildid'] == '')
{
	$subspecialid = $specialid;
    $subspecialname = $special['specialname'];
	$sublinkurl = $special['linkurl'];
	$special = $spe->get_info($special['parentid']);
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
$specialbanner = imgurl($specialbanner);

$head['title'] = $CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];

if(!$templateid) $templateid = 'special_show';
include template($mod, $templateid);
?>