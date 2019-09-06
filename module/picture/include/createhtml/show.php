<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$tablename = channel_table('picture', $channelid);
$itemid = $pictureid = isset($pictureid) ? intval($pictureid) : 0;
if(!$pictureid) return FALSE;
$picture = $db->get_one("SELECT * FROM ".channel_table('picture', $channelid)." WHERE pictureid=$pictureid ");
if(!$picture['pictureid'] || $picture['islink'] || !$picture['ishtml'] || $picture['status'] != 3) return FALSE;
extract($picture);
unset($picture);

if($MOD['enable_reword']) $introduce = reword($introduce);
if($MOD['enable_keylink']) $introduce = keylink($introduce);

if(!isset($TEMP['fields'][$tablename])) $TEMP['fields'][$tablename] = cache_read($tablename.'_fields.php');
$fields = array();
if(is_array($TEMP['fields'][$tablename]))
{
	foreach($TEMP['fields'][$tablename] as $k=>$v)
	{
		$myfield = $v['name'];
		$$myfield = "<a href='".linkurl($$myfield)."' title='".$v['title']."' id='".$v['name']."' target='_blank'/>".linkurl($$myfield)."</a>";
		$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
	}
}
$CAT = isset($TEMP['cat'][$catid]) ? $TEMP['cat'][$catid] : $TEMP['cat'][$catid] = cache_read('category_'.$catid.'.php');
$enableprotect = $CAT['enableprotect'];

$headtitle = $head['title'] = $title."-".$CHA['channelname'];
$head['keywords'] = $keywords.($keywords ? ',' : '').$CAT['seo_keywords'].",".$CHA['seo_keywords'].",".$CHA['channelname'];
$head['description'] = str_cut(strip_tags(trim($introduce)), 50);

if($copyfrom && preg_match("/^(.*)\|([a-zA-Z0-9\-\.\:\/]{5,})$/", $copyfrom, $m))
{
	$copyfromname = $m[1] ? $m[1] : $m[2];
	$copyfromurl = $m[2];
	if(strpos($copyfromurl, "://") === FALSE) $copyfromurl = 'http://'.$copyfromurl;
}
else
{
	$copyfromname = $copyfrom ? str_cut(trim(str_replace(array('#','|'), array('',''), $copyfrom)), 20) : $LANG['internet'];
	$copyfromurl = '#';
}
unset($copyfrom);
$itemurl = linkurl($linkurl, 1);
$adddate = date('Y-m-d H:i:s', $addtime);
$position = isset($TEMP['catpos'][$catid]) ? $TEMP['catpos'][$catid] : $TEMP['catpos'][$catid] = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];
$urls = explode("\n", $pictureurls);
$urls = array_map("trim", $urls);
$pictureurls = array();
$r = array();
foreach($urls as $k=>$url)
{
	if($url == '') continue;
	$url = explode("|", $url);
	$r['id'] = $k+1;
	$r['alt'] = $url[0];

	if(strpos($url[1], "://"))
	{
		$r['src']  = $r['thumb'] = $url[1];
	}
	else
	{
		$thumb_exists = file_exists(PHPCMS_ROOT.'/'.$PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.dirname($url[1]).'/thumb_'.basename($url[1])) ? true : false;
		if($MOD['show_mode'])
		{
			$r['src'] = $CHA['linkurl'].'show_pic.php?src='.$url[1];
			$r['thumb'] = $thumb_exists ? $CHA['linkurl'].'show_pic.php?src='.dirname($url[1]).'/thumb_'.basename($url[1]) : $r['src'];
		}
		else
		{
			$r['src'] = imgurl($PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.$url[1]);
			$r['thumb'] = $thumb_exists ? dirname($r['src']).'/thumb_'.basename($r['src']) : $r['src'];
		}
	}
	$r['href'] = linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $pictureid, $addtime, $r['id']));
	$pictureurls[] = $r;
}
$thumb_maxwidth = isset($MOD['thumb_maxwidth']) ? $MOD['thumb_maxwidth'] : 200;
$img_maxwidth = isset($MOD['img_maxwidth']) ? $MOD['img_maxwidth'] : 550;
$skinid = $skinid ? $skinid : $CAT['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = $templateid ? $templateid : $CAT['defaultitemtemplate'];
$templateid = $templateid ? $templateid : "content";

$ispage = false;
if(isset($page) && $page <= count($pictureurls))
{
	$img_alt = $pictureurls[$page-1]['alt'];
	$img_src = $pictureurls[$page-1]['src'];
	$pages = picpage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, count($pictureurls), $page);
	$ispage = true;
}
$pagenum = count($pictureurls);
for($ii = 0; $ii<=$pagenum; $ii++)//$i在模板中已经出现，不可用
{
	if($ii == 0)
	{
		$ispage = false;
		ob_start();
		include template($mod, $templateid);
		$data = ob_get_contents();
		ob_clean();
		$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $pictureid, $addtime);
		$filepath = dirname($filename);
		is_dir($filepath) or dir_create($filepath);
		file_put_contents($filename,$data);
		@chmod($filename, 0777);
	}
	else
	{
		$ispage = true;
		$img_alt = $pictureurls[$ii-1]['alt'];
		$img_src = $pictureurls[$ii-1]['src'];
		$pages = picpage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, count($pictureurls), $ii);
		$head['title'] = $img_alt.'-'.$headtitle;
		ob_start();
		include template($mod, $templateid);
		$data = ob_get_contents();
		ob_clean();
		$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $pictureid, $addtime, $ii);
		$filepath = dirname($filename);
		file_put_contents($filename,$data);
		@chmod($filename, 0777);
	}

}
return TRUE;
?>