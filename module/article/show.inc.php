<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['invalid_Parameters'], $PHP_SITEURL);
$tablename = channel_table('article', $channelid);
$article = $db->get_one("SELECT * FROM $tablename WHERE articleid=$itemid ");
$article or showmessage($LANG['article_not_exists'], 'goback');
if($article['islink'])
{
	header('location:'.$article['linkurl']);
	exit;
}
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

$CAT = cache_read('category_'.$catid.'.php');
$enableprotect = $CAT['enableprotect'];

$myfields = cache_read($tablename.'_fields.php');
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
$img_maxwidth = isset($MOD['img_maxwidth']) ? $MOD['img_maxwidth'] : 550;
$adddate = date('Y-m-d H:i:s', $addtime);
$position = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];

if(!$arrgroupidview) $arrgroupidview = $CAT['arrgroupid_view'] ? $CAT['arrgroupid_view'] : $CHA['arrgroupid_view'];

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
		$charnumber = strlen($content);
		if($charnumber > $maxcharperpage)
		{
			$page = isset($page) ? intval($page) : 1;
			$pagenumber = ceil($charnumber/$maxcharperpage);
			if($pagenumber>1)
			{
				$offset = ($page-1)*$maxcharperpage;
				$content = get_substr($content, $offset, $maxcharperpage);
				$pages = articlepage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber, $page);
			}
		}
	}
	elseif($paginationtype==2)
	{
		if(strpos($content, '[next]'))
		{
			$content = explode('[next]',$content);
			$pagenumber = count($content);
			$page = isset($page) ? intval($page) : 1;
			$content = $content[$page-1];
			$pages = articlepage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber, $page);
		}
	}
	if($readpoint > 0)
	{
		if(!array_key_exists('pay', $MODULE)) showmessage($LANG['module_pay_not_exists']);
        require PHPCMS_ROOT.'/pay/include/pay.func.php';
		if(!$_userid) showmessage($LANG['article_pay'].$readpoint.$LANG['point'].$LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
		if($_chargetype)
		{
			check_time();
		}
		elseif(!is_exchanged($_userid.'-'.$channelid.'-'.$itemid, $CAT['chargedays']))
        {
			$readurl = $CHA['linkurl'].'readpoint.php?itemid='.$articleid;
			$content = str_cut(strip_tags($content), 200).preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['point_message']);
		}
	}
	if($MOD['enable_reword']) $content = reword($content);
	if($MOD['enable_keylink']) $content = keylink($content);
}

if(!$skinid) $skinid = $CAT['defaultitemskin'];
if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = $CAT['defaultitemtemplate'] ? $CAT['defaultitemtemplate'] : 'content';

include template($mod, $templateid);
if(!$readpoint && !$arrgroupidview) phpcache();
?>