<?php
require './include/common.inc.php';

$id = intval($id);
$ads = $db->get_one("SELECT adsid,linkurl FROM ".TABLE_ADS." WHERE adsid=$id","CACHE",10240);

if($ads)
{
	$db->query("UPDATE ".TABLE_ADS." SET hits=hits+1 WHERE adsid=".$ads['adsid']);
	$url = $ads['linkurl'];
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href = "<?=$url?>";
//-->
</SCRIPT>
