<?php
define('SHOWJS', 1);
require './include/common.inc.php';
require MOD_ROOT.'/include/global.func.php';

$placeid = intval($id);

$query ="SELECT * FROM ".TABLE_ADS." AS a LEFT JOIN ".TABLE_ADS_PLACE." AS p ON (a.placeid=p.placeid) WHERE a.placeid=".$placeid." AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND p.passed=1 AND a.passed=1 AND a.checked=1 ORDER BY a.addtime";
$ads = $db->get_one($query, "CAHCE", 10240);
if(!$ads) exit('document.write("")');

$db->query("UPDATE ".TABLE_ADS." SET views=views+1 WHERE adsid=".$ads['adsid']);

$content = ads_content($ads);
$templateid = $ads['templateid'] ? $ads['templateid'] : 'ads';
include template('ads', $templateid);
phpcache();
?>