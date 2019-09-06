<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$itemid = $itemid ? intval($itemid) : showmessage($LANG['illegal_operation']);
$movie = $db->get_one("SELECT movieid,title,onlineview,serverid,playerid,autoselect,movieurls,arrgroupidview,readpoint,lastviewtime FROM ".channel_table('movie', $channelid)." WHERE movieid = $itemid ");
$movie or showmessage($LANG['movie_not_exist_deleted'], 'goback');
extract($movie);
unset($movie);
update_view($movieid);
if(!$onlineview) showmessage($LANG['not_allow_onlineview']);
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

@extract($db->get_one("SELECT serverid,onlineurl,isapi,maxnum,num FROM ".TABLE_MOVIE_SERVER." WHERE serverid = $serverid "));
if($num >= $maxnum && $maxnum)
{
	showmessage($LANG['maxnum_online']);
}
else
{
	$db->query("UPDATE ".TABLE_MOVIE_SERVER." SET `num` = (num+1) WHERE serverid = $serverid ");
}

$m = explode('^',trim($movieurls));
foreach($m AS $k=>$v)
{
	$mm = explode('|',$v);
	if($id == $k)	$fileurl = $mm[1];
}
$shortUrl = $fileurl;//短地址
if(!preg_match("/^http:\/\/|rtsp:\/\/|mms:\/\/|mmst:\/\//",$fileurl))
{
	$fileurl =$onlineurl.$fileurl;
}
if(preg_match("/\?/",$shortUrl))
$relative =  TRUE;//采用bobo播放器播放，为真则无须获取bobo地址

$tureUrl = $fileurl;//完整地址

if($autoselect)
{
	$fileExt = pathinfo($fileurl);
	$fileExt = $fileExt["extension"];
	if(preg_match("/rm|rmvb|avi|smi/",$fileExt)){
		$playerid = 3;// playerid =3 采用 精美real播放器
	}
	elseif(preg_match("/flv/",$fileExt)){
		$playerid = 4;//  playerid =4 采用 FLV 播放器
	}
	elseif(preg_match("/swf/",$fileExt)){
		$playerid = 5;//  playerid =5 采用 FLASH 播放器
	}
	else{
		$playerid = 2;//playerid =2 采用window media player
	}
}

$echoUrl = FALSE;
if($playerid == 2)	$echoUrl = TRUE;
$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
$auth = urlencode(phpcms_auth("movieid=$movieid&id=$id&fileurl=$fileurl&starttime=$PHP_TIME&ip=$PHP_IP&echoUrl=$echoUrl", 'ENCODE', $authkey));
extract($db->get_one("SELECT * FROM ".TABLE_MOVIE_PLAYER." WHERE playerid = $playerid "));

switch($playerid)
{
	case 6://playerid =6 采用bobo  p2p 播放器
		//根据提供的ISAPI地址获取bobo地址
		
		$shortUrl = trim($isapi.$shortUrl);
		if(!$relative){
		$shortUrl = file_get_contents($shortUrl);
		}
		$code = str_replace('{$serverpath}',$onlineurl,$code);
		$code = str_replace('{$filepath}',$shortUrl,$code);
	break;
	case 4:	//  playerid =4 采用 FLV 播放器
		$filepath = $tureUrl;
		if($MOD['enable_virtualwall'])
		{
			require MOD_ROOT.'/include/vsid.func.php';
			$filepath = $filepath.'?vsid='.getvsid();
		}
		$code = str_replace('{$filepath}',$filepath,$code);
		$code = str_replace('{$PHPCMS[siteurl]}',$PHPCMS['siteurl'],$code);
	break;
	default:
		$filepath = $channelurl."playurl.php?auth=".$auth;
		$code = str_replace('{$filepath}',$filepath,$code);
		$code = str_replace('{$PHPCMS[siteurl]}',$PHPCMS['siteurl'],$code);
		$code = str_replace('{$title}',$title,$code);
		$code = str_replace('{$PHPCMS[sitename]}',$PHPCMS['sitename'],$code);
		$code = str_replace('{$tureUrl}',$tureUrl,$code);
	break;
}
$skinid = $CAT['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = "play";
include template($mod, $templateid);
unset($code,$auth,$m);
?>