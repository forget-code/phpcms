<?php

defined('IN_PHPCMS') or exit('Access Denied');
if(isset($submit))
{
	if(!$brand_name) showmessage($LANG['brand_name_not_null'],"goback");
	
	$checkrepeatsql="SELECT brand_name FROM ".TABLE_PRODUCT_BRAND." WHERE  brand_name='".$brand_name."'";
	$db->query($checkrepeatsql);
	if($db->affected_rows()>0)
	{
		showmessage($LANG['brand_name_repeat'],$referer);
	}
	
	$query="insert into ".TABLE_PRODUCT_BRAND." (`brand_name`) values('$brand_name')";
	$db->query($query);
	$proid = $db->insert_id();
	if(cache_brands() && $proid) showmessage($LANG['operation_success'],$referer);
}
?> 