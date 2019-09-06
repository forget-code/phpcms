<?php
$pro_id= intval($pro_id);
$res=$db->query("SELECT att_id,pro_id FROM ".TABLE_PRODUCT_ATT." WHERE pro_id='$pro_id'");
if(mysql_num_rows($res)>0)
{
	showmessage($LANG['delete_attribute_first'],"?mod=$mod&file=$file&action=manage");
}
else
{ 					
	$db->query("DELETE FROM ".TABLE_PRODUCT_PROPERTY." WHERE pro_id=".$pro_id);
	showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
}
?>