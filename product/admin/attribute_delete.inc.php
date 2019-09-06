<?php
defined('IN_PHPCMS') or exit('Access Denied');
$att_id= intval($att_id);
$db->query("DELETE FROM ".TABLE_PRODUCT_ATT." WHERE att_id=$att_id");
showmessage($LANG['operation_success'],"?mod=$mod&file=attribute&action=manage&pro_id=$pro_id");
?>