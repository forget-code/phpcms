<?php
defined('IN_PHPCMS') or exit('Access Denied');

$job = $job ? $job : 'manage';
$catid = isset($catid) ? intval($catid) : 0;
$srchtype = isset($srchtype) ? intval($srchtype) : 0;
$ordertype = isset($ordertype) ? intval($ordertype) : 0;
$pagesize = isset($pagesize) ? $pagesize : $PHPCMS['pagesize'];
$keywords = isset($keywords) ? $keywords : '';

$jobs=array("manage"=>"disabled=0 ","recycle"=>"disabled=1");
array_key_exists($job, $jobs) or showmessage($LANG['illegal_action'], 'goback');
$referer = urlencode("?mod=$mod&file=$file&action=manage&job=$job&catid=$catid&srchtype=$srchtype&keywords=$keywords&ordertype=$ordertype&pagesize=$pagesize");
$cat_pos = admin_catpos($catid);
$category_select = category_select('catid', $LANG['select_category'], $catid);
$category_jump = category_select('catid', $LANG['select_category_manage'], $catid, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=manage&job=$job&catid='+this.value;}\"");

$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$pagesize;

$sql = $jobs[$job];
$sql.= $catid ? " AND catid=$catid " : '';
$sql.= isset($posid) ? " AND posid=1 " : '';
if(!empty($keywords))
{
	$keyword = preg_replace('/[ |*]/','%',$keywords);
	$srchtypes = array(" AND pdt_name LIKE '%$keyword%'", " AND pdt_No LIKE '%$keyword%' ", " AND price LIKE '%$keyword%' ", " AND brand_id LIKE '%$keyword%' ");
	$sql.=$srchtypes[$srchtype];
}
$orders = array('listorder DESC', 'listorder ASC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC');
$query = "";
$products = $pdtcls->get_list($sql, $orders[$ordertype]);
@extract($db->get_one("SELECT COUNT(*) AS number FROM ".TABLE_PRODUCT." WHERE $sql"),EXTR_OVERWRITE);//Number
$pages = phppages($number,$page,$pagesize);

include admintpl('product_manage');
?>