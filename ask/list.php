<?php
require './include/common.inc.php';
$catid = intval($catid);
$catid or showmessage($LANG['illegal_parameters'], SITE_URL);
if(!array_key_exists($catid, $CATEGORY)) showmessage($LANG['illegal_parameters'],'goback');

$CAT = cache_read('category_'.$catid.'.php');
@extract($CAT);

$head['keywords'] = $catname;
$head['description'] = $head['title'] = $catname.'_'.$M['name'].'_'.$PHPCMS['sitename'];

$array = array('all','vote','solve','high','nosolve');
foreach($array AS $arr)
{
	$$arr = caturl($arr);
}

if($child==1)
{
	$arrchildid = subcat('ask',$catid);
	$templateid = 'category' ;
}
else
{
	$templateid = 'category_list';
}
include template('ask', $templateid);
?>