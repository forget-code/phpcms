<?php
require './include/common.inc.php';
require 'ip_area.class.php';

$ip_area = new ip_area();
$id = intval($id);
$ads = $c_ads->get_info($id);

if($ads)
{
	$db->query("UPDATE ".DB_PRE."ads SET `views`=views+1 WHERE adsid=".$ads['adsid']);
	
	$info['username'] = $_username;
	$info['clicktime'] = time();
	$info['ip'] = IP;
	$info['ads_id'] = $id;
	$info['area'] = $ip_area->get(IP);
	$info['userid']=$_userid;
	$info['referer']=$referer;
	$info['domain']=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
	$info['type']=0;
	$table = DB_PRE.'ads_'.date('ym',TIME);
	$db->insert($table, $info);
}
?>