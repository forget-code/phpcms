<?php
require dirname(__FILE__).'/include/common.inc.php';

$areaid = intval($areaid);
if(!isset($AREA[$areaid])) showmessage('访问的地区不存在！');

$catid = intval($catid);
if(!isset($CATEGORY[$catid])) showmessage('访问的栏目不存在！');
$C = cache_read('category_'.$catid.'.php');

$A = cache_read('area_'.$areaid.'.php');
extract($A);
$head['title'] = $name;
$head['keywords'] = $meta_keywords;
$head['description'] = $meta_description;

$page = max(intval($page), 1);

$catlist = submodelcat($C['modelid']);
unset($catlist[$catid]);

$arrchildid = $CATEGORY[$catid]['arrchildid'];

if($child)
{
	$areas = subarea($areaid);
	$arr_areaid = $AREA[$areaid]['arrchildid'];
	$template = $template ? $template : 'area';
}
else
{
	$template = 'area_list';
}
include template('phpcms', $template);
?>