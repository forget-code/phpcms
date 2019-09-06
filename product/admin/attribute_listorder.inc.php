<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!is_array($listorder)) showmessage($LANG['no_any_post'],$referer);;
foreach($listorder as $att_id=>$value)
{
	$value = intval($value);
	$att_id= intval($att_id);
	$db->query("UPDATE ".TABLE_PRODUCT_ATT." SET listorder=$value WHERE att_id=$att_id");
}
showmessage($LANG['operation_success'],$referer);
?>