<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$itemid = $movieid = isset($movieid) ? intval($movieid) : 0;
if(!$movieid) return FALSE;
$movie = $db->get_one("SELECT * FROM ".channel_table('movie', $channelid)." WHERE movieid=$movieid ");
if(!$movie['movieid'] || $movie['islink'] || !$movie['ishtml'] ||  $movie['status'] != 3) return FALSE;
extract($movie);
unset($movie);
@extract($db->get_one("SELECT name AS areaType FROM ".TABLE_TYPE." WHERE typeid=$typeid "));

if($MOD['enable_reword']) $introduce = reword($introduce);
if($MOD['enable_keylink']) $introduce = keylink($introduce);

if(!isset($TEMP['fields'][$tablename])) $TEMP['fields'][$tablename] = cache_read($tablename.'_fields.php');
$fields = array();
if(is_array($TEMP['fields'][$tablename]))
{
	foreach($TEMP['fields'][$tablename] as $k=>$v)
	{
		$myfield = $v['name'];
		if($v['inputtool']=='imageupload' || $v['inputtool']=='fileupload')
		$$myfield = "<a href='".linkurl($$myfield)."' title='".$v['title']."' id='".$v['name']."' target='_blank'/>".linkurl($$myfield)."</a>";
		$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
	}
}
$CAT = isset($TEMP['cat'][$catid]) ? $TEMP['cat'][$catid] : $TEMP['cat'][$catid] = cache_read('category_'.$catid.'.php');

$enableprotect = $CAT['enableprotect'];

$head['title'] = $title."-".$CHA['channelname'];
$head['keywords'] = $keywords.",".$CAT['seo_keywords'].",".$CHA['seo_keywords'].",".$CHA['channelname'];
$head['description'] = $CAT['seo_description'].'-'.$CHA['seo_description']."-".$CHA['channelname'];

$itemurl = linkurl($linkurl, 1);
$adddate = date('Y-m-d',$addtime);
$position = isset($TEMP['catpos'][$catid]) ? $TEMP['catpos'][$catid] : $TEMP['catpos'][$catid] = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];
//
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

ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $movieid, $addtime);
$filepath = dirname($filename);
is_dir($filepath) or dir_create($filepath);
file_put_contents($filename,$data);
@chmod($filename, 0777);
return TRUE;
?>