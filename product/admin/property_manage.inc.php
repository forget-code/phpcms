<?php
defined('IN_PHPCMS') or exit('Access Denied');
$page = isset($page) ? intval($page) : 1;
$offset=($page-1)*$PHPCMS['pagesize'];
$result=$db->query("SELECT count(*) as num FROM ".TABLE_PRODUCT_PROPERTY);
$r=$db->fetch_array($result);
$number=$r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);
$query ="SELECT p.pro_id as pid,a.pro_id,pro_name,disabled,count(att_id) as pro_num  ".
		"FROM ".TABLE_PRODUCT_PROPERTY." as p ".
		"LEFT JOIN ".TABLE_PRODUCT_ATT." as a ".
		"ON a.pro_id=p.pro_id  GROUP BY p.pro_id limit $offset,$PHPCMS[pagesize] ";
		// order by id desc limit $offset,$PHPCMS[pagesize]

$result=$db->query($query);
$properties = array();
while($r=$db->fetch_array($result))
{
	$properties[]=$r;
}
$properties=array_reverse($properties);	

include admintpl('property_manage');
?> 