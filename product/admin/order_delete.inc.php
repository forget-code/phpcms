<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(isset($odr_ids) && is_array($odr_ids))
{
	$odr_id = implode(',',$odr_ids);
}
else if(isset($odr_id))
{
$odr_id= intval($odr_id);
}
$db->query("DELETE FROM ".TABLE_PRODUCT_ORDER." WHERE odr_id IN ($odr_id)");
$db->query("DELETE FROM ".TABLE_PRODUCT_CART." WHERE odr_id IN ($odr_id)");
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>