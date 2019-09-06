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
	if($star<1 || $star>5) $star = 3;
	$stars_1 = array('', '★', '★★', '★★★', '★★★★', '★★★★★');
	$stars_2 = array('', '☆', '☆☆', '☆☆☆', '☆☆☆☆', '☆☆☆☆☆');
	return '<span style="color:'.$color.';">'.$stars_1[$star].$stars_2[5-$star].'</span>';
}

function update_view($movieid)
{
	global $db, $channelid, $PHP_TIME;
	$r = array();
	$r = $db->get_one("SELECT movieid,lastviewtime from ".channel_table('movie', $channelid)." WHERE movieid=$movieid ");
    if(!$r['movieid']) return false;
	$lastviewtime = $r['lastviewtime'];
	$lastviewdate = date('Y-m-d',$lastviewtime);
	$lastviewweek = date('W',$lastviewtime);
	$lastviewmonth = date('Y-m',$lastviewtime);
	$today = date('Y-m-d',$PHP_TIME);
	$week = date('W',$PHP_TIME);
	$month = date('Y-m',$PHP_TIME);
	$todayview = $lastviewdate == $today ? 'todayview+1' : 1;
	$weekview = $lastviewweek == $week ? 'weekview+1' : 1;
	$monthview = $lastviewmonth == $month ? 'monthview+1' : 1;
	$db->query("UPDATE ".channel_table('movie', $channelid)." SET totalview=totalview+1,todayview=$todayview,weekview=$weekview,monthview=$monthview,lastviewtime=$PHP_TIME WHERE movieid=$movieid ");
	return true;
}

function update_movie_url($movieid)
{
	global $db, $channelid;
	$movieid = intval($movieid);
	$channelid = intval($channelid);
	if(!$movieid || !$channelid) return FALSE;
	$movie = $db->get_one("select * from ".channel_table('movie', $channelid)." where movieid=$movieid ");
	if(empty($movie))  return FALSE;
	$linkurl = item_url('url', $movie['catid'], $movie['ishtml'], $movie['urlruleid'], $movie['htmldir'], $movie['prefix'], $movieid, $movie['addtime']);
	$db->query("update ".channel_table('movie', $channelid)." set linkurl='$linkurl' where movieid=$movieid ");
	return TRUE;
}
?>