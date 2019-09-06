<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['illegal_operation'], $PHP_SITEURL);
$tablename = channel_table('down', $channelid);
$down = $db->get_one("SELECT * FROM $tablename WHERE downid=$itemid ");
$down or showmessage($LANG['download_not_exist_deleted'], 'goback');
if($down['islink'])
{
	header('location:'.$down['linkurl']);
	exit;
}
extract($down);
unset($down);

if($MOD['enable_reword']) $introduce = reword($introduce);
if($MOD['enable_keylink']) $introduce = keylink($introduce);

$myfields = cache_read($tablename.'_fields.php');
$fields = array();
if(is_array($myfields))
{
	foreach($myfields as $k=>$v)
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
$CAT = cache_read('category_'.$catid.'.php');
$enableprotect = $CAT['enableprotect'];

if(!$arrgroupidview)
{
	$arrgroupidview = $CAT['arrgroupid_view'] ? $CAT['arrgroupid_view'] : $CHA['arrgroupid_view'];
}

$itemurl = linkurl($linkurl, 1);

$adddate = date('Y-m-d',$addtime);
$position = catpos($catid);
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
	$downurls = array();
	$r = array();
	foreach($servers as $k=>$server)
	{
		$r['id'] = $k;
		$r['name'] = $server['showtype'] ? '<img src="'.$server['logo'].'" alt="'.$server['name'].'" />' : $server['name'];
		$downurls[] = $r;
	}
}
$thumb = imgurl($thumb);
$stars = stars($stars);
$password = $MOD['password'] ? $MOD['password'] : $LANG['no'];

if(!$skinid) $skinid = $CAT['defaultitemskin'];
if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = $CAT['defaultitemtemplate'] ? $CAT['defaultitemtemplate'] : 'content';

$head['title'] = $title.'-'.$CHA['channelname'];
$head['keywords'] = $keywords.($keywords ? ',' : '').$CAT['seo_keywords'].','.$CHA['seo_keywords'].','.$CHA['channelname'];
$head['description'] = str_cut(strip_tags(trim($introduce)), 100);

include template($mod, $templateid);
phpcache();
?>