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
$sql .= isset($areaid) ? " AND areaid=$areaid " : '';
$orders = array('listorder DESC,displayid DESC', 'listorder ASC', 'displayid DESC', 'displayid ASC', 'hits DESC', 'hits ASC');
$sql.=' ORDER BY '.$orders[$ordertype];
@extract($db->get_one("SELECT COUNT(displayid) AS number FROM ".TABLE_HOUSE_DISPLAY." WHERE status=$status $sql"), EXTR_OVERWRITE);
$pages = phppages($number,$page,$pagesize);

$displays = array();
$result = $db->query("SELECT * FROM ".TABLE_HOUSE_DISPLAY." WHERE status=$status $sql LIMIT $offset,$pagesize ");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d',$r['addtime']);
	$r['name'] = style($r['name'], $r['style']);
	$r['linkurl'] = linkurl($r['linkurl']);
	$r['areaname'] = $AREA[$r['areaid']]['areaname'];
	$displays[] = $r;	
}
include admintpl('display_manage');
?>