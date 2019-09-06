<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$isjs = isset($isjs) ? 1 : 0;

dir_create(PHPCMS_ROOT.'/data/'.$MOD['htmldir'].'/');

$result = $db->query("SELECT placeid FROM ".TABLE_ADS_PLACE." ORDER BY placeid DESC");
while($r = $db->fetch_array($result))
{
	$placeid = $r['placeid'];
	createhtml('adsplace');
}

$isjs ? showmessage($LANG['update_js_successed']) : showmessage($LANG['update_html_successed'], $PHP_URL.'&isjs=1');
?>