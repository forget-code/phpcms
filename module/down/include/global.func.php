<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function msg($msg, $referer = '', $timeout = 2000)
{
	if(!$referer)
	{
		global $PHP_REFERER; 
		$referer = $PHP_REFERER;
	}
	echo '<table width="100%" cellpadding="0" cellspacing="0"  height="100%" bgcolor="#F1F3F5">';
	echo '<tr><td style="font-size:12px;color:blue;">';
	echo '<a href="'.$referer.'">'.$msg.' Click To Back</a>';
	echo '</td></tr></table>';
	echo '<script>setTimeout("window.location=\''.$referer.'\'", '.$timeout.');</script>';
	exit;
}

function stars($star = 3, $color = 'red')
{
	global $LANG;
	if($star<1 || $star>5) $star = 3;
	$stars_1 = array('', $LANG['filled_star'], $LANG['filled_star'].$LANG['filled_star'], $LANG['filled_star'].$LANG['filled_star'].$LANG['filled_star'], $LANG['filled_star'].$LANG['filled_star'].$LANG['filled_star'].$LANG['filled_star'], $LANG['filled_star'].$LANG['filled_star'].$LANG['filled_star'].$LANG['filled_star'].$LANG['filled_star']);
	$stars_2 = array('', $LANG['dew_star'], $LANG['dew_star'].$LANG['dew_star'], $LANG['dew_star'].$LANG['dew_star'].$LANG['dew_star'], $LANG['dew_star'].$LANG['dew_star'].$LANG['dew_star'].$LANG['dew_star'], $LANG['dew_star'].$LANG['dew_star'].$LANG['dew_star'].$LANG['dew_star'].$LANG['dew_star']);
	return '<span style="color:'.$color.';">'.$stars_1[$star].$stars_2[5-$star].'</span>';
}

function update_downs($downid)
{
	global $db, $channelid, $PHP_TIME;

	$r = array();
	$r = $db->get_one("select downid,lastdowntime from ".channel_table('down', $channelid)." where downid=$downid ");
    if(!$r['downid']) return false;

	$lastdowndate = date('Y-m-d',$r['lastdowntime']);
	$lastdownweek = date('W',$r['lastdowntime']);
	$lastdownmonth = date('Y-m',$r['lastdowntime']);

	$today = date('Y-m-d',$PHP_TIME);
	$week = date('W',$PHP_TIME);
	$month = date('Y-m',$PHP_TIME);

	$todaydowns = $lastdowndate == $today ? 'todaydowns+1' : 1;
	$weekdowns = $lastdownweek == $week ? 'weekdowns+1' : 1;
	$monthdowns = $lastdownmonth == $month ? 'monthdowns+1' : 1;

	$db->query("update ".channel_table('down', $channelid)." set totaldowns=totaldowns+1,todaydowns=$todaydowns,weekdowns=$weekdowns,monthdowns=$monthdowns,lastdowntime=$PHP_TIME where downid=$downid ");
	return true;
}

function redirect($fileurl)
{
	header("location:".$fileurl);
	exit;
}

function update_down_url($downid)
{
	global $db, $channelid;
	$downid = intval($downid);
	$channelid = intval($channelid);
	if(!$downid || !$channelid) return FALSE;
	$down = $db->get_one("select * from ".channel_table('down', $channelid)." where downid=$downid ");
	if(empty($down))  return FALSE;
	$linkurl = item_url('url', $down['catid'], $down['ishtml'], $down['urlruleid'], $down['htmldir'], $down['prefix'], $downid, $down['addtime']);
	$db->query("update ".channel_table('down', $channelid)." set linkurl='$linkurl' where downid=$downid ");
	return TRUE;
}

function ThunderEncode($url) 
{
	$thunderPrefix = "AA";
	$thunderPosix = "ZZ";
	$thunderTitle = "thunder://";
	$thunderUrl = $thunderTitle.base64_encode($thunderPrefix.$url.$thunderPosix);
	return $thunderUrl;
}

function FlashgetEncode($t_url, $uid) 
{
	$prefix = "Flashget://";
	$FlashgetURL = $prefix.base64_encode("[FLASHGET]".$t_url."[FLASHGET]")."&".$uid;
	return $FlashgetURL;
}
?>