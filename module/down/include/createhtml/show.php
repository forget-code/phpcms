<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$itemid = $downid = isset($downid) ? intval($downid) : 0;
if(!$downid) return FALSE;
$tablename = channel_table('down', $channelid);
$down = $db->get_one("SELECT * FROM $tablename WHERE downid=$downid");
if(!$down || $down['islink'] || !$down['ishtml'] ||  $down['status'] != 3) return FALSE;
extract($down);
unset($down);

if($MOD['enable_reword']) $introduce = reword($introduce);
if($MOD['enable_keylink']) $introduce = keylink($introduce);

if(!isset($TEMP['fields'][$tablename])) $TEMP['fields'][$tablename] = cache_read($tablename.'_fields.php');
$fields = array();
if(is_array($TEMP['fields'][$tablename]))
{
	foreach($TEMP['fields'][$tablename] as $k=>$v)
	{
		if($v['fieldid']>9)
		{
			$myfield = $v['name'];
			if($v['inputtool']=='imageupload' || $v['inputtool']=='fileupload')
			$$myfield = "<a href='".linkurl($$myfield)."' title='".$v['title']."' id='".$v['name']."' target='_blank'/>".linkurl($$myfield)."</a>";
			$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
		}
	}
}
$CAT = isset($TEMP['cat'][$catid]) ? $TEMP['cat'][$catid] : $TEMP['cat'][$catid] = cache_read('category_'.$catid.'.php');
$enableprotect = $CAT['enableprotect'];

if(!$arrgroupidview)
{
	$arrgroupidview = $CAT['arrgroupid_view'] ? $CAT['arrgroupid_view'] : $CHA['arrgroupid_view'];
}

$itemurl = linkurl($linkurl, 1);
$adddate = date('Y-m-d',$addtime);
$position = isset($TEMP['catpos'][$catid]) ? $TEMP['catpos'][$catid] : $TEMP['catpos'][$catid] = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];
if($mode == 0)
{
	$urls = explode("\n", $downurls);
	$urls = array_map('trim', $urls);
	$downurls = array();
	$r = array();
	foreach($urls as $k=>$url)
	{
		if($url == '') continue;
		$url = explode('|', $url);
		$r['id'] = $k;
		$r['name'] = $url[0];
		$r['url'] = $url[1];
		if(strpos($r['url'], '://') === FALSE) $r['url'] = $PHP_SITEURL.$r['url'];
		$downurls[] = $r;
	}
}
else
{
	$servers = cache_read('mirror_server.php');
	$morror_dowm_url = $downurls;
	$downurls = array();
	$r = array();
	foreach($servers as $k=>$server)
	{
		$r['id'] = $k;
		$r['name'] = $server['showtype'] ? '<img src="'.$server['logo'].'" alt="'.$server['name'].'" />' : $server['name'];
		$r['url'] = $server['url'].$morror_dowm_url;
		$downurls[] = $r;
	}
}
$thumb = imgurl($thumb);
$stars = stars($stars);
$password = $MOD['password'] ? $MOD['password'] : $LANG['have_no'];

if(!$skinid) $skinid = $CAT['defaultitemskin'];
if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = $CAT['defaultitemtemplate'] ? $CAT['defaultitemtemplate'] : 'content';

$head['title'] = $title.'-'.$CHA['channelname'];
$head['keywords'] = $keywords.($keywords ? ',' : '').$CAT['seo_keywords'].','.$CHA['seo_keywords'].','.$CHA['channelname'];
$head['description'] = str_cut(strip_tags(trim($introduce)), 100);

ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $downid, $addtime);
$filepath = dirname($filename);
is_dir($filepath) or dir_create($filepath);
file_put_contents($filename,$data);
@chmod($filename, 0777);
return TRUE;
?>