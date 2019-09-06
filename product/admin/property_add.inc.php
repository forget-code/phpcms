<?php
defined('IN_PHPCMS') or exit('Access Denied');


if(isset($submit))
{
	if(!$pro_name) showmessage($LANG['product_attribute_not_null'],"goback");
	
	//先判断重复
	$checkrepeatsql="SELECT pro_name FROM ".TABLE_PRODUCT_PROPERTY." WHERE  pro_name='".$pro_name."'";
	$db->query($checkrepeatsql);
	if($db->affected_rows()>0)
	{
		showmessage($LANG['product_attribute_repeat'],$referer);
	}
	
	$query="insert into ".TABLE_PRODUCT_PROPERTY." (`pro_name`) values('$pro_name')";
	$db->query($query);
	$proid = $db->insert_id();
	if($proid) showmessage($LANG['operation_success'],$referer);
}
?> 