<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if(isset($downid)) $downid = intval($downid);
if(!isset($id)) showmessage($LANG['illegal_parameters']);
$id = intval($id);
if(!$downid || $id<0) showmessage($LANG['illegal_parameters']);

$r = $db->get_one("select downid,catid,title,mode,downurls,arrgroupidview,readpoint from ".channel_table('down', $channelid)." where downid=$downid ");
if(!$r) showmessage($LANG['file_not_exist_or_deleted']);
extract($r);
unset($r);

$CAT = cache_read('category_'.$catid.'.php');

$mirror = '';
if($mode)
{
	$server = cache_read('mirror_server.php');
	if(array_key_exists($id, $server))
	{
		$mirror = $server[$id]['url'];
		$fileurl = $mirror.trim($downurls);
	}
	else
	{
		showmessage($LANG['illegal_parameters']);
	}
}
else
{
	$downurls = explode("\n", $downurls);
	if(array_key_exists($id, $downurls))
	{
        $thedown = explode('|', $downurls[$id]);
		$fileurl = trim($thedown[1]);
	}
	else
	{
		showmessage($LANG['illegal_parameters']);
	}
}

if(strpos($fileurl, 'http://') !== FALSE || strpos($fileurl, '://') === FALSE)
{
	$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
	$auth = urlencode(phpcms_auth("downid=$downid&fileurl=$fileurl&starttime=$PHP_TIME&ip=$PHP_IP&mirror=$mirror", 'ENCODE', $authkey));
	$downurl = $channelurl.'download.php?auth='.$auth;
}
else
{
	$downurl = $fileurl;
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
	$auth = '';
}
else
{
	if($readpoint > 0)
	{
		if(!array_key_exists('pay', $MODULE)) showmessage($LANG['module_pay_not_exists']);
        require PHPCMS_ROOT.'/pay/include/pay.func.php';
		if(!$_userid) showmessage($LANG['downloadable_deduction'].$readpoint.$LANG['check_logging'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
		if($_chargetype)
		{
			check_time();
		}
		elseif(!is_exchanged($_userid.'-'.$channelid.'-'.$downid, $CAT['chargedays']))
        {
			$readurl = $CHA['linkurl'].'readpoint.php?itemid='.$downid.'&id='.$id;
			$purview_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['point_message']);
			$auth = '';
		}
	}
}
//User Rights

$head['title'] = $title.'-'.$CHA['channelname'];
$head['keywords'] = $keywords.($keywords ? ',' : '').$CAT['seo_keywords'].','.$CHA['seo_keywords'].','.$CHA['channelname'];
$head['description'] = str_cut(strip_tags(trim($introduce)), 100);

include template($mod, 'down');
?>