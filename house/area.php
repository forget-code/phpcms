<?php 
require './include/common.inc.php';
if($infocat) $tab = $infocat;
$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
$areaid = intval($areaid);
$areaid or showmessage($LANG['illegal_parameters'],$PHP_SITEURL);
$infocat = isset($infocat) ? intval($infocat) : 0;
if(!array_key_exists($areaid, $AREA)) showmessage($LANG['sorry_not_exist_area'],'goback');
include  PHPCMS_ROOT.'/include/area.func.php';
$ARE = cache_read('area_'.$areaid.'.php');
@extract($ARE);
$areapos = areapos($areaid, ' &gt;&gt; ');
if($child==1)
{
	$arrchild = subarea($mod, $areaid);
	$templateid = $templateid ? $templateid : 'area_list' ;
}
else
{	
	$page = isset($page) ? intval($page) : 1;
	$templateid = $listtemplateid ? $listtemplateid : 'area_list';
}
include template($mod,$templateid);
?>