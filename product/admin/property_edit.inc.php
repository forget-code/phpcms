<?php
defined('IN_PHPCMS') or exit('Access Denied');
//属性编辑
defined('IN_PHPCMS') or exit('Access Denied');

if (isset($submit)) 
{
	if(empty($pro_id)) showmessage($LANG['illegal_parameters']);
	$pro_id=intval($pro_id);
	if(!$pro['pro_name']) showmessage($LANG['product_attribute_not_null'],"goback");
	$pro['disabled']=($pro['disabled']>0)?1:0;
	
	$query="UPDATE ".TABLE_PRODUCT_PROPERTY.
		   " SET pro_name='$pro[pro_name]',disabled=$pro[disabled] ".
		   " WHERE pro_id=$pro_id";	
	$db->query($query);
	showmessage($LANG['operation_success_record_modified'],"?mod=$mod&file=$file&action=manage&pro_id=$att[pro_id]");
}
if(empty($pro_id)) showmessage($LANG['illegal_parameters']);
$pro = $db->get_one("SELECT * FROM ".TABLE_PRODUCT_PROPERTY." where pro_id = $pro_id limit 1");
$pro=new_htmlspecialchars($pro);
if (count($pro)<1) showmessage($LANG['cannot_find_record_return'],$referer);
include admintpl("property_edit");
?> 