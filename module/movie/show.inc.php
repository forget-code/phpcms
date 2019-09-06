<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['illegal_operation'], $PHP_SITEURL);
$movie = $db->get_one("SELECT * FROM ".channel_table('movie', $channelid)." WHERE movieid=$itemid ");
$movie or showmessage($LANG['movie_not_exist_deleted'], 'goback');
if($movie['islink'])
{
	header('location:'.$movie['linkurl']);
	exit;
}
extract($movie);
unset($movie);
@extract($db->get_one("SELECT name AS areaType FROM ".TABLE_TYPE." WHERE typeid=$typeid "));

if($MOD['enable_reword']) $introduce = reword($introduce);
if($MOD['enable_keylink']) $introduce = keylink($introduce);

$myfields = cache_read('phpcms_'.$mod.'_'.$channelid.'_fields.php');
$fields = array();
if(is_array($myfields))
{
	foreach($myfields as $k=>$v)
	{
		$myfield = $v['name'];
		if($v['inputtool']=='imageupload' || $v['inputtool']=='fileupload')
		$$myfield = "<a href='".linkurl($$myfield)."' title='".$v['title']."' id='".$v['name']."' target='_blank'/>".linkurl($$myfield)."</a>";
		$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
	}
}
$CAT = cache_read('category_'.$catid.'.php');
$enableprotect = $CAT['enableprotect'];

$head['title'] = $title."-".$CHA['channelname'];
$head['keywords'] = $keywords.",".$CAT['seo_keywords'].",".$CHA['seo_keywords'].",".$CHA['channelname'];
$head['description'] = $CAT['seo_description'].'-'.$CHA['seo_description']."-".$CHA['channelname'];

$itemurl = linkurl($linkurl, 1);

$adddate = date('Y-m-d',$addtime);
$position = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];
//movieurls
$m = explode('^',trim($movieurls));
$editEndnum = count($m) + 1;
$showTxt = $movieUrls = array();
foreach($m AS $k=>$v)
{
	$mm = explode('|',$v);
	$showTxt['id'] = $k;
	$showTxt['txt'] = $mm[0];
	$movieUrls[] = $showTxt;
}

$thumb = imgurl($thumb);
$stars = stars($stars);

$skinid = $skinid ? $skinid : $CAT['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = $templateid ? $templateid : $CAT['defaultitemtemplate'];
$templateid = $templateid ? $templateid : "content";

include template($mod, $templateid);
if(!$readpoint && !$arrgroupidview) phpcache();
?>