<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

$head['title'] = $CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];


$childcats = subcat($channelid, 0, 'list');
if(is_array($childcats))
{
	foreach($childcats as $i=>$cat)
	{
		$subcats[$i] = subcat($channelid,$cat['catid']);
	}
}

$mainareas = subarea($channelid);

$templateid = $CHA['templateid'] ? $CHA['templateid'] : "index";
include template($mod,$templateid);
phpcache();
?>