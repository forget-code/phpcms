<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
//if($PHP_DOMAIN && $PHP_REFERER && !preg_match("/".$PHP_DOMAIN."/i",$PHP_REFERER)) showmessage($LANG['content_from'].'<a href="'.$channelurl.'" >'.$channelurl.'</a> ,'.$LANG['enter_download']);
if(!isset($auth)) showmessage($LANG['illegal_parameters']);
$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
$auth = phpcms_auth($auth, 'DECODE', $authkey);
if(empty($auth)) showmessage($LANG['illegal_parameters']);
parse_str($auth);
if(!isset($downid)) showmessage($LANG['illegal_parameters']);
if(!isset($fileurl)) showmessage($LANG['illegal_parameters']);
if(!isset($starttime)) showmessage($LANG['illegal_parameters']);
if(!isset($ip)) showmessage($LANG['illegal_parameters']);
if(!isset($mirror)) showmessage($LANG['illegal_parameters']);
$starttime = intval($starttime);
$downid = intval($downid);
$fileurl = trim($fileurl);
if(!$downid || empty($fileurl) || !preg_match("/[0-9]{10}/", $starttime) || !preg_match("/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/", $ip) || $ip != $PHP_IP) showmessage($LANG['illegal_parameters']);
if($MOD['expire'])
{
	$endtime = $PHP_TIME - $starttime;
	if($endtime > $MOD['expire']*60) showmessage($LANG['url_spent']);
}

update_downs($downid);

if($MOD['enable_virtualwall'])
{
	require MOD_ROOT.'/include/vsid.func.php';
	$fileurl = $fileurl.'?vsid='.getvsid();
	redirect($fileurl);
}
elseif(strpos($fileurl, '://'))//远程文件
{
	$urlfopen = ini_get('allow_url_fopen');
	if(preg_match("/^http:\/\//i", $fileurl)) //HTTP
	{
		if($mirror != '' && $MOD['mirror_file'] && $MOD['auth_key'])
		{
			$endtime = $starttime + $MOD['expire']*60;
			$fileurl = str_replace($mirror, '', $fileurl);
			$auth = urlencode(phpcms_auth("fileurl=$fileurl&key=$MOD[auth_key]&endtime=$endtime", 'ENCODE', $MOD['auth_key']));
			$fileurl = $mirror.$MOD['mirror_file'].'.php?auth='.$auth;
			redirect($fileurl);
		}
		elseif($urlfopen && $MOD['remote_showurl'] == 0)
		{
			file_down($fileurl);
		}
		else
		{
			redirect($fileurl);
		}
	}
	elseif(preg_match("/^(ftp|ftps):\/\//i", $fileurl)) //FTP
	{
		if($urlfopen && $MOD['remote_showurl'] == 0)
		{
			file_down($fileurl);
		}
		else
		{
			redirect($fileurl);
		}
	}
	else
	{
		redirect($fileurl);
	}
}
else//本地文件
{
	if($MOD['local_showurl'] == 1)
	{
		redirect($PHP_SITEURL.$fileurl);
	}
	else
	{
		$fileurl = file_exists($fileurl) ? stripslashes($fileurl) : PHPCMS_ROOT.'/'.$fileurl;//此处可能为物理路径
		$filename = basename($fileurl);
		if(preg_match("/^([\s\S]*?)([\x81-\xfe][\x40-\xfe])([\s\S]*?)/", $fileurl))//处理中文文件
		{
			$filename = str_replace(array("%5C", "%2F", "%3A"), array("\\", "/", ":"), urlencode($fileurl));
			$filename = urldecode(basename($filename));
		}
		file_down($fileurl, $filename);
	}
}
?>