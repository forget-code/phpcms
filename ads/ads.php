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
$today = time(date("Y-m-d"));

$ads = $db->get_one("SELECT p.templateid,p.width,p.height,a.adsid,a.type,a.linkurl,a.imageurl,a.alt,a.flashurl,a.wmode,a.text,a.code FROM ".TABLE_ADS_PLACE." p, ".TABLE_ADS." a WHERE p.placeid=a.placeid and p.placeid='$id' AND a.passed=1 and fromdate<='$today' and todate>='$today' ORDER BY a.adsid DESC LIMIT 0,1","CACHE",43200);

if(!$ads['adsid']) die("document.write(\"\");");

$db->query("UPDATE ".TABLE_ADS." SET views=views+1 WHERE adsid=".$ads['adsid']);

$content = ads_content($ads);
$templateid = $ads['templateid'];

include template('ads',$templateid);
?>