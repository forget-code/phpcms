<?php

defined('IN_PHPCMS') or exit('Access Denied');
if(isset($submit))
{
	if(!$brand['brand_name']) showmessage($LANG['brand_name_not_null']);

	$sql="UPDATE ".TABLE_PRODUCT_BRAND.
		" SET brand_name='".$brand['brand_name']."',brand_description='".$brand['brand_description']."',brand_frequency='".$brand['brand_frequency']."',brand_icon='".$brand['brand_icon']."' ".
		"WHERE brand_id=".$brand_id;	
	$result=$db->query($sql);
	cache_brands();
	showmessage($LANG['operation_success_record_modified'],"?mod=$mod&file=$file&action=manage");
}
if(empty($brand_id)) showmessage($LANG['illegal_parameters']);
$brand = $db->get_one("SELECT * FROM ".TABLE_PRODUCT_BRAND." where brand_id = $brand_id limit 1");
$brand=new_htmlspecialchars($brand);
if (count($brand)<1) showmessage($LANG['cannot_find_record_return'],$referer);
include admintpl("brand_edit");
?> 