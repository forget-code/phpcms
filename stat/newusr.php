<?php
include './include/common.inc.php';
$language = strtolower($language);
if($language == 'zh-cn')
{
	$language = $LANG['simplified_chinese'];
} 
elseif(in_array($language, array('zh-tw', 'zh-hk', 'zh-mo', 'zh-sg')))
{
	$language = $LANG['traditional_chinese'];
}
$db->query("INSERT INTO ".TABLE_STAT_VISITOR." (vip,osys,lang,broswer,screen,color,alexa,times,etime,tweek,beon) VALUES('$vip','$osys','$language','$browser','$screen','$color','$alexa','$times',NOW(),WEEK(CURDATE(),1),1)");
if($db->affected_rows() > 0)
{
	$vid = $db->insert_id();
	mkcookie('vid', $vid, $PHP_TIME + $interval);
	$row = $db->get_one("SELECT aid FROM ".TABLE_STAT_AREA." WHERE vip='$vip'");
	if(!$row)
	{
		include PHPCMS_ROOT.'/include/ip.class.php';
		$ip = new ip;
		$temp = $ip->getlocation($vip);
		$address = $temp['country'];
		if($address) 
		{
			include MOD_ROOT.'/include/province.func.php';
			$province = getProvince($temp['country']);
			if(!$province) $province = $temp['country'];
		}
		else 
		{
			$address = $LANG['unknown'];
			$province = "&nbsp;";
		}
		$db->query("INSERT INTO ".TABLE_STAT_AREA." (vip,address,province) VALUES('$vip','$address','$province')");
	}
	if($refurl)
	{
		$temp = parse_url($refurl);
		if (strtolower(substr($temp['host'], 0, 4)) == 'www.') 
		{
			$rdomain = substr($temp['host'], 4);
		}
		else
		{
			$rdomain = $temp['host'];
		}
		include MOD_ROOT.'/include/keyword.func.php';
		$keyword =  keyWord($refurl);
	}
	else
	{
		$refurl = $LANG['location_column_input'];
		$rdomain = '';
		$keyword = '';
	}
	$db->query("INSERT INTO ".TABLE_STAT_VPAGES." (vid,refurl,rdomain,keyword,pageurl,filen,ftime) VALUES($vid,'$refurl','$rdomain','$keyword','$pageurl','$filename',NOW())");
	if($db->affected_rows()) mkcookie('pid', $db->insert_id(), $PHP_TIME + $interval);
}
?>