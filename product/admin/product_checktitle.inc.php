<?php
defined('IN_PHPCMS') or exit('Access Denied');
$PHPCMS['sitename'] = $LANG['check_repeat_name']." - $title - ";
if(empty($title))
{
	$message = '<font color="red">'.$LANG['input_product_name'].'</font>';
}
else
{
	$result=$db->query("SELECT productid,pdt_name FROM ".TABLE_PRODUCT." WHERE disabled=0 AND pdt_name LIKE '%$title%'");
	$articles=$db->fetch_array($result);
	if(empty($articles))
	{
		$message = '<font color="blue">'.$LANG['product_not_exist_continue'].'</font>';
	}
	else
	{
		$message = '<font color="red">'.$LANG['product_exist_return_to_manage'].'</font>';
	}
}
include admintpl('product_checktitle');
?>