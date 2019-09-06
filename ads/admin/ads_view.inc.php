<?php
defined('IN_PHPCMS') or exit('Access Denied');
$adsid = intval($adsid);

$query ="SELECT a.*,p.*".
		"FROM ".TABLE_ADS." as a left join ".TABLE_ADS_PLACE." as p on (a.placeid=p.placeid)".
    "where a.adsid=".$adsid;

$ads=$db->get_one($query);

if(empty($ads)) exit("<SCRIPT LANGUAGE=\"JavaScript\">document.write(\"".$LANG['no_advertising_on_this_place']."\")</SCRIPT>");

$db->query("UPDATE ".TABLE_ADS." SET views=views+1 WHERE adsid=".$ads['adsid']);

$content = ads_content($ads);
$templateid = $ads['templateid'] ? $ads['templateid'] : "ads";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
<?php
include template('ads',$templateid);
?>
//-->
</SCRIPT>