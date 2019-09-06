<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['illegal_parameters'], $PHP_SITEURL);
$tablename = channel_table('picture', $channelid);
$picture = $db->get_one("SELECT * FROM $tablename WHERE pictureid=$itemid");
$picture or showmessage($LANG['current_picture_not_exist_or_delete'], 'goback');
if(isset($page))
{
	$page = intval($page);
	$page > 0 or showmessage($LANG['illegal_parameters'], $PHP_SITEURL);
}
if($picture['islink'])
{
	header('location:'.$picture['linkurl']);
	exit;
}
extract($picture);
unset($picture);

if($MOD['enable_reword']) $introduce = reword($introduce);
if($MOD['enable_keylink']) $introduce = keylink($introduce);

$myfields = cache_read($tablename.'_fields.php');
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

$itemurl = linkurl($linkurl, 1);
$adddate = date('Y-m-d H:i:s', $addtime);
$position = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];
$urls = explode("\n", $pictureurls);
$urls = array_map('trim', $urls);
$pictureurls = array();
$r = array();
foreach($urls as $k=>$url)
{
	if($url == '') continue;
	$url = explode('|', $url);
	$r['id'] = $k+1;
	$r['alt'] = $url[0];

	if(strpos($url[1], '://'))
	{
		$r['src']  = $r['thumb'] = $url[1];
	}
	else
	{
		$thumb_exists = file_exists(PHPCMS_ROOT.dirname($url[1]).'/thumb_'.basename($url[1])) ? true : false;
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

$adddate = date('Y-m-d', $addtime);
$thumb_maxwidth = isset($MOD['thumb_maxwidth']) ? $MOD['thumb_maxwidth'] : 200;
$img_maxwidth = isset($MOD['img_maxwidth']) ? $MOD['img_maxwidth'] : 550;

if(!$skinid) $skinid = $CAT['defaultitemskin'];
if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = $CAT['defaultitemtemplate'] ? $CAT['defaultitemtemplate'] : 'content';

$ispage = false;
$urlnum = count($pictureurls);
if(isset($page) && $page <= $urlnum)
{
	$ispage = true;
	$img_alt = $pictureurls[$page-1]['alt'];
	$img_src = $pictureurls[$page-1]['src'];
	$head['title'] = $img_alt.'-'.$head['title'];
	$pages = picpage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $urlnum, $page);
	unset($pictureurls);
}
// User Rights
if(!$arrgroupidview)
{
	$arrgroupidview = $CAT['arrgroupid_view'] ? $CAT['arrgroupid_view'] : $CHA['arrgroupid_view'];
}
$purview_message = '';
if($arrgroupidview && !check_purview($arrgroupidview))
{
    $purview_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['purview_message']);
	$pictureurls = array();
}
else
{
	if($readpoint > 0)
	{
		if(!array_key_exists('pay', $MODULE)) showmessage($LANG['module_pay_not_exists']);
        require PHPCMS_ROOT.'/pay/include/pay.func.php';
		if(!$_userid) showmessage($LANG['view_picture_take_out']." $readpoint ".$LANG['point_login_then_view'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
		if($_chargetype)
		{
			check_time();
		}
		elseif(!is_exchanged($_userid.'-'.$channelid.'-'.$itemid, $CAT['chargedays']))
        {
			$readurl = $CHA['linkurl'].'readpoint.php?itemid='.$pictureid;
			$purview_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['point_message']);
			$pictureurls = array();
		}
	}
}
$head['keywords'] = $keywords;
include template($mod, $templateid);
if(!$readpoint && !$arrgroupidview) phpcache();
?>