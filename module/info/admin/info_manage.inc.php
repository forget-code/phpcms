<?php
defined('IN_PHPCMS') or exit('Access Denied');
$job = $job ? $job : 'manage';
$jobs = array("manage"=>"status=3 ", "check"=>"status=1", "recycle"=>"status=-1", "myitem"=>"username='$_username'");
array_key_exists($job, $jobs) or showmessage($LANG['illegal_action'], 'goback');

$AREA = cache_read('areas_'.$channelid.'.php');

$catid = isset($catid) ? intval($catid) : 0;
$srchtype = isset($srchtype) ? intval($srchtype) : 0;
$ordertype = isset($ordertype) ? intval($ordertype) : 0;
$arrposid = isset($arrposid) ? intval($arrposid) : 0;
$typeid = isset($typeid) ? intval($typeid) : 0;
$areaid = isset($areaid) ? intval($areaid) : 0;
$cat_pos = admin_catpos($catid);
$category_select = category_select('catid', $LANG['select_category'], $catid);
$category_jump = category_select('catid', $LANG['select_category_to_manage'], $catid, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=manage&job=$job&channelid=$channelid&catid='+this.value;}\"");
$pos_select = pos_select($channelid, "arrposid", $LANG['recommend_position'], $arrposid);
$type_select = type_select('typeid', $LANG['type'], $typeid);

$page = isset($page) ? $page : 1;
$offset = $page ? ($page-1)*$pagesize : 0;

$sql = $jobs[$job];
$sql.= $catid ? " AND catid=$catid " : '';
$sql.= $arrposid ? " AND arrposid like '%,$arrposid,%' " : '';
$sql.= $typeid ? " AND typeid=$typeid " : '';
if($areaid)
{
	$areaids = $AREA[$areaid]['arrchildid']; 
	$sql .= " AND areaid IN ($areaids) ";
}

$keywords = !empty($keywords) ? trim($keywords) : '';
if($keywords)
{
	$keyword=preg_replace('/[ |*]/','%',$keywords);
	$srchtypes = array(" AND title LIKE '%$keyword%'", " AND introduce LIKE '%$keyword%' ", " AND author LIKE '%$keyword%' ", " AND username LIKE '%$keyword%' ");
	$sql.=$srchtypes[$srchtype];
}
$orders = array('listorder DESC, infoid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
$infos = $inf->get_list($sql, $orders[$ordertype]);
$r = $db->get_one("SELECT COUNT(*) AS number FROM ".channel_table('info', $channelid)." WHERE $sql");
$pages = phppages($r['number'], $page, $pagesize);
$referer = urlencode("?mod=$mod&file=$file&action=$action&job=$job&channelid=$channelid&catid=$catid&areaid=$areaid&srchtype=$srchtype&keywords=$keywords&ordertype=$ordertype&page=$page&pagesize=$pagesize");
$area_select = area_select('areaid', $LANG['belong_area'], $areaid);
include admintpl($mod.'_'.$job);
?>