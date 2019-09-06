<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['invalid_Parameters'], $PHP_SITEURL);
$article = $db->get_one("SELECT * FROM ".channel_table('article', $channelid)." WHERE articleid=$itemid ");
$article or showmessage($LANG['article_not_exists'], 'goback');
if($article['islink'])
{
	header('location:'.$article['linkurl']);
	exit;
}
extract($article);
unset($article);
extract($db->get_one("SELECT content FROM ".channel_table('article_data', $channelid)." WHERE articleid=$itemid "));

$CAT = cache_read('category_'.$catid.'.php');

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

$head['title'] = $title.'-'.$CHA['channelname'];
$head['keywords'] = $keywords.','.$CAT['seo_keywords'].','.$CHA['seo_keywords'].','.$CHA['channelname'];
$head['description'] = $CAT['seo_description'].'-'.$CHA['seo_description'].'-'.$CHA['channelname'];

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
$adddate = date('Y-m-d H:i:s',$addtime);
$position = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];

if(!$arrgroupidview)
{
	$arrgroupidview = $CAT['arrgroupid_view'] ? $CAT['arrgroupid_view'] : $CHA['arrgroupid_view'];
}

if($arrgroupidview && !check_purview($arrgroupidview))
{
    $content = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['purview_message']);
}
else
{
	$pages = '';
	$pagenumber = 0;
	if($paginationtype==1)
	{
		$page = isset($page) ? intval($page) : 1;
		$charnumber = strlen($content);
		$pagenumber = ceil($charnumber/$maxcharperpage);
		if($pagenumber>1)
		{
			$offset = ($page-1)*$maxcharperpage;
			$content = get_substr($content, $offset, $maxcharperpage);
			$pages = articlepage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber, $page);
		}
	}
	elseif($paginationtype==2)
	{
		$page = isset($page) ? intval($page) : 1;
		$content = strpos($content, '[next]') ? explode('[next]',$content) : $content;
		if(is_array($content))
		{
			$pagenumber = count($content);
			if($pagenumber>1) 
			{
				$content = $content[$page-1];
				$pages = articlepage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber, $page);
			}
		}
	}
	if($readpoint > 0)
	{
        require PHPCMS_ROOT.'/pay/include/pay.func.php';
		if(!$_userid) showmessage($LANG['article_pay'].$readpoint.$LANG['point'].$LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
		if($_chargetype)
		{
			check_time();
		}
		elseif(!getcookie('article_'.$articleid))
        {
			$readurl = $CHA['linkurl'].'readpoint.php?itemid='.$articleid;
			$content = str_cut(strip_tags($content), 200).preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['point_message']);
		}
	}
	if($MOD['enable_reword']) $content = reword($content);
	if($MOD['enable_keylink']) $content = keylink($content);
}

$skinid = $skinid ? $skinid : $CAT['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = $templateid ? $templateid : $CAT['defaultitemtemplate'];
$templateid = $templateid ? $templateid : 'content';

include template($mod, $templateid);
if(!$readpoint && !$arrgroupidview) phpcache();
?>