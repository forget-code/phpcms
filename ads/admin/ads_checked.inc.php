<?php
defined('IN_PHPCMS') or exit('Access Denied');

$val = $val==1 ? 1 : 0;

if(is_numeric($adsid))
{
	$db->query("update ".TABLE_ADS." set checked = $val where adsid=$adsid");
}
elseif(is_array($adsid))
{
	$adsids = implode(",", $adsid);
	$db->query("update ".TABLE_ADS." set checked = $val where adsid in ($adsids)");
}

$forward = '?mod='.$mod.'&file=createhtml';
showmessage($LANG['opration_completed'], $forward);
?>