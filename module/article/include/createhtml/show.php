<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$itemid = $articleid = isset($articleid) ? intval($articleid) : 0;
if(!$articleid) return FALSE;
$article = $db->get_one("SELECT * FROM ".channel_table('article', $channelid)." WHERE articleid=$articleid ");
if(!$article['articleid'] || $article['islink'] || !$article['ishtml'] || $article['status'] != 3) return FALSE;
extract($article);
unset($article);
$r = $db->get_one("SELECT content FROM ".channel_table('article_data', $channelid)." WHERE articleid=$articleid ");
$content = $r['content'];

if($MOD['enable_reword']) $content = reword($content);
if($MOD['enable_keylink']) $content = keylink($content);

$myfields = cache_read('phpcms_'.$mod.'_'.$channelid.'_fields.php');
$fields = array();
if(is_array($myfields))
{
	foreach($myfields as $k=>$v)
	{
		$myfield = $v['name'];
		$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
	}
}
$CAT = cache_read('category_'.$catid.'.php');

$head['title'] = $title."-".$CHA['channelname'];
$head['keywords'] = $keywords.",".$CAT['seo_keywords'].",".$CHA['seo_keywords'].",".$CHA['channelname'];
$head['description'] = $CAT['seo_description'].'-'.$CHA['seo_description']."-".$CHA['channelname'];

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
if($keywords) $keywords = explode(',', $keywords);
$itemurl = linkurl($linkurl, 1);
$title = $titleintact ? $titleintact : $title;
$img_maxwidth = isset($MOD['img_maxwidth']) ? $MOD['img_maxwidth'] : 550;
$adddate = date('Y-m-d',$addtime);
$position = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];

$skinid = $skinid ? $skinid : $CAT['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = $templateid ? $templateid : $CAT['defaultitemtemplate'];
$templateid = $templateid ? $templateid : "content";

$page = 0;
$pages = '';

$pagenumber = 0;
if($paginationtype==1)
{
	$charnumber = strlen($content);
	$pagenumber = ceil($charnumber/$maxcharperpage);
	$contents = $content;
}
elseif($paginationtype==2)
{
	$contents = strpos($content, '[next]') ? explode('[next]',$content) : $content;
	$pagenumber = is_array($contents) ? count($contents) : 1;
}

if($pagenumber > 1)
{
	for($page = 0; $page <= $pagenumber; $page++)
	{
		if($paginationtype==1)
		{
			$offset = $page*$maxcharperpage;
			$content = get_substr($contents, $offset, $maxcharperpage);
		}
		elseif($paginationtype==2)
		{
			$content = $contents[$page];
		}
		ob_start();
		$pages = articlepage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $articleid, $addtime, $pagenumber, $page);
		include template($mod, $templateid);
		$data = ob_get_contents();
		ob_clean();
		$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $articleid, $addtime, $page);
		$filepath = dirname($filename);
		is_dir($filepath) or dir_create($filepath);
		file_put_contents($filename,$data);
		chmod($filename, 0777);
	}
}
else
{
	ob_start();
	include template($mod, $templateid);
	$data = ob_get_contents();
	ob_clean();
	$filename = PHPCMS_ROOT.'/'.item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $articleid, $addtime, $pagenumber);
	$filepath = dirname($filename);
	is_dir($filepath) or dir_create($filepath);
	file_put_contents($filename, $data);
	chmod($filename, 0777);
}
return TRUE;
?>