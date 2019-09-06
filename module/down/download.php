<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$downid = intval($downid);
if(!$downid) message('非法参数。');

if($PHP_DOMAIN && $PHP_REFERER && !preg_match("/".$PHP_DOMAIN."/i",$PHP_REFERER)) message('您所点击的下载内容来自 <a href="'.$channelurl.'" >'.$channelurl.'</a> ，请进入下载。');

$r = $db->get_one("SELECT * FROM ".TABLE_DOWN." WHERE downid=$downid",'CACHE',86400);
@extract($r);

$cat_arrgroupid_view = $_CAT['arrgroupid_view'] ? $_CAT['arrgroupid_view'] : $_CHA['arrgroupid_view'];
$groupview = $groupview ? $groupview : $cat_arrgroupid_view;

if(!check_purview($groupview))
{
	$readmessage = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie","\\1",$_CHA['purview_message']);
	exit($readmessage);
}

if($readpoint>0)
{
	if(!$_userid) message("下载需要点数！请登录！",PHPCMS_PATH."member/login.php?referer=".urlencode($PHP_URL));
	if($_chargetype)
	{
		charge_time();
	}
	elseif(!getcookie("down_".$downid))
	{
		if($read==1)
		{
			charge_point($readpoint,$title."(downid=".$downid.")");
			$readtime = $_CAT['defaultchargetype'] ? 0 : $timestamp+3600*24*365;
			mkcookie("down_".$downid,1,$readtime);
		}
		else
		{
			$readurl = "?read=1&".$PHP_QUERYSTRING;
			$readmessage = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie","\\1",$_CHA['point_message']);
	        exit($readmessage);
		}
	}
}

update_downs($downid);

$urls = explode("\n",$downurls);
$downurl = trim($urls[$id]);
$downurl = explode("|",$downurl);
$fileurl = trim($downurl[1]);

if(empty($fileurl)) message("下载地址不存在！","goback");

$filename = preg_match("|/([^/]+)$|i",$fileurl,$info) ? $info[1] : "download.byphpcms";

if(strpos($fileurl,"://"))
{
	$urlfopen = @get_cfg_var("allow_url_fopen");
	$enabledns = preg_match("/^[0-9\.]{7,15}/i",@gethostbyname($PHP_DOMAIN));

	if(preg_match("/^http:\/\//i",$fileurl))
	{
		if($urlfopen && $enabledns && preg_match("/\.(doc|gif|jpg|jpeg|png|bmp|swf|wav|rm|mp3|mp4|mid|rmvb|asf|asx|wmf|mov|midi)$/i",$fileurl))
		{
		    $filesize = 0;
			$filetype = fileext($filename);
		}
		else
		{
			header("location:".$fileurl);
			exit;
		}
	}
	elseif($urlfopen && $enabledns)
	{
		if(phpversion() > '5.0.0' && preg_match("/^(ftp|ftps):\/\//i",$fileurl))
		{
			$filesize = @filesize($fileurl);
		}
		$filesize = $filesize ? $filesize : 0;
		$filetype = fileext($filename);
	}
	else
	{
		echo "点击下载：<a href='".$fileurl."'>".$fileurl."</a>";
		exit;
	}
}
else
{
	$fileurl = PHPCMS_ROOT."/".$fileurl;
	$filesize = filesize($fileurl);
	$filetype = fileext($filename);
    $filename = preg_match("|/([^/]+)$|i",$fileurl,$info) ? $info[1] : "download.byphpcms";
}

ob_end_clean();

header('Cache-control: max-age=31536000');
header('Expires: '.gmdate('D, d M Y H:i:s', $timestamp + 31536000).' GMT');
header('Content-Encoding: none');
if($filesize) header('Content-Length: '.$filesize);
//forbid flash be opened directly
//header('Content-Disposition: '.(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ').'filename='.$filename);
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Type: '.$filetype);

@readfile($fileurl);

function update_downs($downid)
{
	global $db,$timestamp;
	$r = $db->get_one("select downid,lastdowntime from ".TABLE_DOWN." where downid='$downid'");
    if(!$r['downid']) return false;
	@extract($r);
	$lastdowndate = date('Y-m-d',$lastdowntime);
	$lastdownweek = date('W',$lastdowntime);
	$lastdownmonth = date('Y-m',$lastdowntime);

	$today = date('Y-m-d',$timestamp);
	$week = date('W',$timestamp);
	$month = date('Y-m',$timestamp);

	//更新今日下载次数
	$todaydowns = $lastdowndate==$today ? 'daydowns+1' : 1;
	//更新本周下载次数
	$weekdowns = $lastdownweek==$week ? 'weekdowns+1' : 1;
	//更新本月浏览次数
	$monthdowns = $lastdownmonth==$month ? 'monthdowns+1' : 1;
	//更新最后下载日期
	$db->query("update ".TABLE_DOWN." set downs=downs+1,daydowns=$todaydowns,weekdowns=$weekdowns,monthdowns=$monthdowns,lastdowntime=$timestamp where downid=$downid ");
	return true;
}
?>