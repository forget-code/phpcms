<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$ads = $db->get_one("SELECT * FROM ".TABLE_ADS." a, ".TABLE_ADS_PLACE." p WHERE a.placeid=p.placeid AND p.placeid=$placeid AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND a.passed=1 AND a.checked=1 LIMIT 1");
$content = ads_content($ads, $isjs);
$templateid = $ads['templateid'] ? $ads['templateid'] : 'ads';
ob_start();
include template('ads', $templateid);
$data = ob_get_contents();
ob_clean();
$filename = $isjs ? PHPCMS_ROOT.'/data/'.$MOD['htmldir'].'/'.$placeid.'.js' : PHPCMS_ROOT.'/data/'.$MOD['htmldir'].'/'.$placeid.'.html';
file_put_contents($filename, $data);
@chmod($filename, 0777);
?>