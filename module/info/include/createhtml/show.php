<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$itemid = $infoid = isset($infoid) ? intval($infoid) : 0;
if(!$infoid) return FALSE;
$tablename = channel_table('info', $channelid);
$info = $db->get_one("SELECT * FROM $tablename WHERE infoid=$infoid ");
if(!$info || $info['islink'] || !$info['ishtml'] ||  $info['status'] != 3) return FALSE;
extract($info);
unset($info);

$AREA = isset($TEMP['area'][$channelid]) ? $TEMP['area'][$channelid] : $TEMP['area'][$channelid] = cache_read('areas_'.$channelid.'.php');

if($MOD['enable_reword']) $content = reword($content);
if($MOD['enable_keylink']) $content = keylink($content);

if(!isset($TEMP['fields'][$tablename])) $TEMP['fields'][$tablename] = cache_read($tablename.'_fields.php');
$fields = array();
if(is_array($TEMP['fields'][$tablename]))
{
	foreach($TEMP['fields'][$tablename] as $k=>$v)
	{
		$myfield = $v['name'];
		$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
	}
}
$CAT = isset($TEMP['cat'][$catid]) ? $TEMP['cat'][$catid] : $TEMP['cat'][$catid] = cache_read('category_'.$catid.'.php');

$enableprotect = $CAT['enableprotect'];

$head['title'] = $title.'-'.$CHA['channelname'];
$head['keywords'] = $keywords.($keywords ? ',' : '').$CAT['seo_keywords'].','.$CHA['seo_keywords'].','.$CHA['channelname'];
$head['description'] = str_cut(strip_tags(trim($content)), 100);
$point_message = '';
$itemurl = linkurl($linkurl, 1);
$adddate = date('Y-m-d',$addtime);
$position = isset($TEMP['catpos'][$catid]) ? $TEMP['catpos'][$catid] : $TEMP['catpos'][$catid] = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];
$thumb = linkurl(imgurl($thumb), 1);
$adddate = date('Y-m-d', $addtime);
$enddate = $endtime ? date('Y-m-d', $endtime) : $LANG['no_limit'];

if(!$skinid) $skinid = $CAT['defaultitemskin'];
if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = $CAT['defaultitemtemplate'] ? $CAT['defaultitemtemplate'] : 'content';

ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $infoid, $addtime);
$filepath = dirname($filename);
is_dir($filepath) or dir_create($filepath);
file_put_contents($filename, $data);
@chmod($filename, 0777);
return TRUE;
?>