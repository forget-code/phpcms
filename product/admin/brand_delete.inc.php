<?php
defined('IN_PHPCMS') or exit('Access Denied');
$brand_id= intval($brand_id);
$db->query("DELETE FROM ".TABLE_PRODUCT_BRAND." WHERE brand_id=$brand_id");
if(cache_brands())	
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>