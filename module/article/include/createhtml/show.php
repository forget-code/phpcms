<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$itemid = $articleid = isset($articleid) ? intval($articleid) : 0;
if(!$articleid) return FALSE;
$tablename = $CONFIG['tablepre'].'article_'.$channelid;
$article = $db->get_one("SELECT * FROM $tablename WHERE articleid=$itemid");
if(!$article || $article['islink'] || !$article['ishtml'] || $article['status'] != 3) return FALSE;
extract($article);
$content = '';
if($MOD['storage_mode'] > 1)
{
	$content = txt_read($channelid, $articleid);
}
else
{
	$r = $db->get_one("SELECT content FROM ".channel_table('article_data', $channelid)." WHERE articleid=$itemid");
	$content = $r['content'];
}
unset($article, $r);

if($MOD['enable_reword']) $content = reword($content);
if($MOD['enable_keylink']) $content = keylink($content);

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

$head['title'] = $title.'-'.$CHA['channelname'];
$head['keywords'] = $keywords.($keywords ? ',' : '').$CAT['seo_keywords'].','.$CHA['seo_keywords'].','.$CHA['channelname'];
$head['description'] = str_cut(strip_tags(trim($introduce)), 100);

if($copyfrom)
{
	$copyfrom = explode('|', $copyfrom);
	$copyfromname = $copyfrom[0];
	$copyfromurl = $copyfrom[1];
}
else
{
	$copyfromname = $LANG['internet'];
	$copyfromurl = '#';
}
unset($copyfrom);
if($keywords) $keys = explode(',', $keywords);
$itemurl = linkurl($linkurl, 1);
if($titleintact) $title = $titleintact;
$title = htmlspecialchars($title);
$img_maxwidth = isset($MOD['img_maxwidth']) ? $MOD['img_maxwidth'] : 550;
$adddate = date('Y-m-d H:i:s', $addtime);
$position = isset($TEMP['catpos'][$catid]) ? $TEMP['catpos'][$catid] : $TEMP['catpos'][$catid] = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];

if(!$skinid) $skinid = $CAT['defaultitemskin'];
if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = $CAT['defaultitemtemplate'] ? $CAT['defaultitemtemplate'] : 'content';

$page = 0;
$pages = '';
$pagenumber = 0;

if($paginationtype==1)
{
	$charnumber = strlen($content);
	if($charnumber > $maxcharperpage)
	{
		$pagenumber = ceil($charnumber/$maxcharperpage);
		$contents = $content;
	}
}
elseif($paginationtype==2)
{
	if(strpos($content, '[next]'))
	{
		$contents = explode('[next]', $content);
		$pagenumber = count($contents);
	}
}

$indexname = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $articleid, $addtime, 0);
$filepath = dirname($indexname);
is_dir($filepath) or dir_create($filepath);

if($pagenumber > 1)
{
	for($i = 0; $i < $pagenumber; $i++)
	{
		$page = $i+1;
		if($paginationtype==1)
		{
			$offset = $i*$maxcharperpage;
			$content = get_substr($contents, $offset, $maxcharperpage);
		}
		elseif($paginationtype==2)
		{
			$content = $contents[$i];
		}
		$pages = articlepage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $articleid, $addtime, $pagenumber, $page);
		$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $articleid, $addtime, $page);
		ob_start();
		include template($mod, $templateid);
		$data = ob_get_contents();
		ob_clean();
		file_put_contents($filename, $data);
		@chmod($filename, 0777);
		if($page == 1)
		{
			copy($filename, $indexname);
			@chmod($indexname, 0777);
		}
	}
}
else
{
	ob_start();
	include template($mod, $templateid);
	$data = ob_get_contents();
	ob_clean();
	file_put_contents($indexname, $data);
	@chmod($indexname, 0777);
}
return TRUE;
?>