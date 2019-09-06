<?php
require './ads/include/common.inc.php';

$id = intval($id);
$ads = $c_ads->get_info($id);

if($ads)
{
	$db->query("UPDATE ".DB_PRE."ads SET `clicks`=clicks+1 WHERE adsid=".$ads['adsid']);
	$info['username'] = $_username;
	$info['clicktime'] = time();
	$info['ip'] = IP;
	$info['adsid'] = $id;
	$info['referer'] = HTTP_REFERER;
	$table = DB_PRE.'ads_stat';
	$db->insert($table, $info);
	$url = strpos($ads['linkurl'], 'http://')===FALSE ? 'http://'.$ads['linkurl'] : $ads['linkurl'];
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href = "<?=$url?>";
-->
</SCRIPT>