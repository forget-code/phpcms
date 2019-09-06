<?php 
defined('IN_PHPCMS') or exit('Access Denied');
ob_start();
tag_data($mod,$tagname);
$preview = ob_get_contents();
ob_clean();
include admintpl('tag_preview');
?>