<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$itemid = $itemid ? intval($itemid) : showmessage($LANG['illegal_operation']);
$movie = $db->get_one("SELECT movieid,title,allowdown,serverid,movieurls,arrgroupidview,readpoint FROM ".channel_table('movie', $channelid)." WHERE movieid = $itemid ");
$movie or showmessage($LANG['movie_not_exist_deleted'], 'goback');
extract($movie);
unset($movie);
if(!$allowdown) showmessage($LANG['not_allow_down']);
if(!$arrgroupidview)
{
	$arrgroupidview = $CAT['arrgroupid_view'] ? $CAT['arrgroupid_view'] : $CHA['arrgroupid_view'];
}
$purview_message = '';

if($arrgroupidview && !check_purview($arrgroupidview))
{
    $purview_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['purview_message']);
	showmessage($CHA['purview_message']);
}
else
{
	if($readpoint > 0)
	{
		if(!array_key_exists('pay', $MODULE)) showmessage($LANG['module_pay_not_exists']);
        require PHPCMS_ROOT.'/pay/include/pay.func.php';
		if(!$_userid) showmessage($LANG['movie_deduction'].$readpoint.$LANG['check_logging'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
		if($_chargetype)
		{
			check_time();
		}
		elseif(!is_exchanged($_userid.'-'.$channelid.'-'.$itemid, $CAT['chargedays']))
        {
			$readurl = $CHA['linkurl'].'readpoint.php?itemid='.$itemid.'&id='.$id;
			$purview_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $CHA['point_message']);
			showmessage($purview_message);
		}
	}
}

@extract($db->get_one("SELECT serverid,downurl FROM ".TABLE_MOVIE_SERVER." WHERE serverid = $serverid "));


$m = explode('^',trim($movieurls));
foreach($m AS $k=>$v)
{
	$mm = explode('|',$v);
	if($id == $k)	$fileurl = $mm[1];
}

$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
$auth = urlencode(phpcms_auth("movieid=$movieid&id=$id&fileurl=$fileurl&starttime=$PHP_TIME&ip=$PHP_IP&downurl=$downurl&diskurl=$diskurl", 'ENCODE', $authkey));
$skinid = $CAT['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = "down";
include template($mod, $templateid);
unset($code,$auth,$m);
?>