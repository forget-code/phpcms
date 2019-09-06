<?php
/**
 * 每次展示广告时的记录
 * 最后更新日期:2008-10-20
 * 最后更新人员:李勇
 */

require './include/common.inc.php';
require 'ip_area.class.php';

//此对象生成的地域信息过于详细,钟经理建议简化,仅区分城市级别,修改了ip_area类
$ip_area = new ip_area();

$id = intval($id);
$ads = $c_ads->get_info($id);

if($ads)
{
	//本广告的点击数加一
	$db->query("UPDATE ".DB_PRE."ads SET `views`=views+1 WHERE adsid=".$ads['adsid']);
	
	//记录点击详细信息
	$info['username'] = $_username;
	$info['clicktime'] = time();
	$info['ip'] = IP;
	$info['ads_id'] = $id;
	$info['area'] = $ip_area->get(IP);
	$info['userid']=$_userid;
	$info['referer']=$referer;
	$info['domain']=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
	$info['type']=0;
	$table = DB_PRE.'ads_stat';
	$db->insert($table, $info);
}
?>