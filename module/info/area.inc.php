<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require_once PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$areaid = intval($areaid);
$areaid or showmessage($LANG['illegal_parameters'],$PHP_SITEURL);

if(!array_key_exists($areaid, $AREA)) showmessage($LANG['sorry_not_exist_area'],'goback');
$ARE = cache_read('area_'.$areaid.'.php');
@extract($ARE);

$head['title'] = $areaname.'-'.$CHA['channelname'].'-'.$CHA['seo_title'];
$head['keywords'] = $seo_keywords.','.$CHA['seo_keywords'];
$head['description'] = $seo_description.'-'.$CHA['seo_description'];

$position = areapos($areaid);
$childareas = subarea($channelid);

if(is_array($childareas))
{
	foreach($childareas as $i=>$area)
	{
		$subareas[$i] = subarea($channelid,$area['areaid']);
	}
}

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
if($child==1)
{
	$arrchildid = subarea($channelid,$areaid);
	$templateid = $templateid ? $templateid : 'area' ;
}
else
{	
	$page = isset($page) ? intval($page) : 1;
	$templateid = $listtemplateid ? $listtemplateid : 'area_list';
}
$childcats = subcat($channelid, 0, 'list');
if(is_array($childcats))
{
	foreach($childcats as $i=>$cat)
	{
		$subcats[$i] = subcat($channelid,$cat['catid']);
	}
}
include template($mod,$templateid);
if(!$enablepurview) phpcache();
?>