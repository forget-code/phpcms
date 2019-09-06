<?php 
require "./config.inc.php";
require "../include/common.inc.php";

$isdomain = false;//
$province = isset($province) ? trim(urldecode($province)) : '';
$city = isset($city) ? trim(urldecode($city)) : '';
$area = isset($area) ? trim(urldecode($area)) : '';

if($province || $city || ($city && $area))
{
	if($isdomain)
	{
		require PHPCMS_ROOT."/module/".$mod."/location_domain.inc.php";
	}
	else
	{
		require PHPCMS_ROOT."/module/".$mod."/location.inc.php";
	}
}
else
{
	if($province) unset($province);
	if($city) unset($city);
	if($area) unset($area);
	if(isset($catid)) unset($catid);
	if(isset($page)) unset($page);
	if(isset($elite)) unset($elite);
	require PHPCMS_ROOT."/module/".$mod."/index.inc.php";
}
?>