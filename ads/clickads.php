<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
require "common.php";

$id = intval($id);
$ads = $db->get_one("SELECT adsid,linkurl FROM ".TABLE_ADS." WHERE adsid=$id LIMIT 0,1","CACHE",43200);
if($ads['adsid'])
{
	$db->query("UPDATE ".TABLE_ADS." SET hits=hits+1 WHERE adsid=".$ads['adsid']);
	$url = $ads[linkurl];
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href = "<?=$url?>";
//-->
</SCRIPT>