<?php
defined('IN_PHPCMS') or exit('Access Denied');

$srchtype = isset($srchtype) ? intval($srchtype) : 0;
$ordertype = isset($ordertype) ? intval($ordertype) : 0;
$pagesize = isset($pagesize) ? $pagesize : $PHPCMS['pagesize'];
$keywords = isset($keywords) ? $keywords : '';
$status = isset($status) ? intval($status) : 1;
$referer = urlencode("?mod=$mod&file=$file&action=manage&status=$status&catid=$catid&srchtype=$srchtype&keywords=$keywords&ordertype=$ordertype&pagesize=$pagesize");

$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$pagesize;

$sql = '';
$sql.= isset($areaid) ? " AND areaid=$areaid " : '';
$sql.= " AND infocat=$typeid ";
if($overdue) $sql.= " AND endtime<$PHP_TIME ";
if(!empty($keywords))
{
	$keyword = preg_replace('/[ |*]/','%',$keywords);
	$srchtypes = array(" AND name LIKE '%$keyword%'", " AND address LIKE '%$keyword%' ");
	$sql.=$srchtypes[$srchtype];
}

$orders = array('listorder DESC,houseid DESC', 'listorder ASC', 'houseid DESC', 'houseid ASC', 'hits DESC', 'hits ASC');
$order = isset($order)?$order:0;
$sql.= " ORDER BY ".$orders[$order];

@extract($db->get_one("SELECT COUNT(houseid) AS number FROM ".TABLE_HOUSE." WHERE status=$status $sql LIMIT $offset,$pagesize "),EXTR_OVERWRITE);//Number
$pages = phppages($number,$page,$pagesize);

$houses = array();
$result = $db->query("SELECT * FROM ".TABLE_HOUSE." WHERE status=$status $sql LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d', $r['addtime']);	
	$r['title'] = style($r['name'], $r['style']);
	$r['linkurl'] = linkurl($r['linkurl']);
	$r['areaname'] = $AREA[$r['areaid']]['areaname'];
	$housetypearr = explode(',', $r['housetype']);
	$housetype = '';
	$stw = array('室','厅','卫','阳台');
	foreach ($housetypearr as $k=>$v)
	{
		$housetype .= $v=='不限' ? '' : $v.$stw[$k];
	}
	$r['housetype'] = $housetype;
	$houses[] = $r;	
}
include admintpl('infomgr_manage');
?>