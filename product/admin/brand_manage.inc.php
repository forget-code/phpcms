<?php
defined('IN_PHPCMS') or exit('Access Denied');


$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$PHPCMS['pagesize'];
$result = $db->query("SELECT count(*) as num FROM ".TABLE_PRODUCT_BRAND);
$r = $db->fetch_array($result);
$number = $r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);

$query ="SELECT * ".
		"FROM ".TABLE_PRODUCT_BRAND.
		" order by brand_frequency desc limit $offset,".$PHPCMS['pagesize'];

$result = $db->query($query);
$brands = array();
while($r=$db->fetch_array($result))
{
	$brands[]=$r;
}
include admintpl('brand_manage');
?> 