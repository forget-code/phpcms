<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['illegal_parameters'], $PHP_SITEURL);
$tablename = channel_table('info', $channelid);
$info = $db->get_one("SELECT * FROM $tablename WHERE infoid=$itemid ");
$info or showmessage($LANG['current_info_not_exist_or_delete'], 'goback');
if($info['islink'])
{
	header('location:'.$info['linkurl']);
	exit;
}
extract($info);
unset($info);

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
$head['description'] = str_cut(strip_tags(trim($content)), 100);

$itemurl = linkurl($linkurl, 1);
$adddate = date('Y-m-d',$addtime);
$position = catpos($catid);

$cat_name = $CAT['catname'];
$cat_url = $CAT['linkurl'];
$thumb = imgurl($thumb);

$adddate = date('Y-m-d', $addtime);
$enddate = $endtime ? date('Y-m-d', $endtime) : $LANG['no_limit'];
$encode_city = urlencode($city);

$point_message = '';
if(!$arrgroupidview)
{
	$arrgroupidview = $CAT['arrgroupid_view'] ? $CAT['arrgroupid_view'] : $CHA['arrgroupid_view'];
}
if($arrgroupidview && !check_purview($arrgroupidview))
{
    $point_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['purview_message']);
}
else
{
	if($readpoint > 0)
	{
		if(!array_key_exists('pay', $MODULE)) showmessage($LANG['module_pay_not_exists']);
        require PHPCMS_ROOT.'/pay/include/pay.func.php';
		if(!$_userid) showmessage($LANG['view_info_take_out']." $readpoint ".$LANG['point_login_then_view'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
		if($_chargetype)
		{
			check_time();
		}
		elseif(!is_exchanged($_userid.'-'.$channelid.'-'.$itemid, $CAT['chargedays']))
        {
			$readurl = $channelurl.'readpoint.php?itemid='.$infoid;
			$point_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['point_message']);
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