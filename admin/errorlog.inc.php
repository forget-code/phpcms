<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'include/xml.func.php';

$submenu = array
(
    array($LANG['new_log'], "?mod=".$mod."&file=".$file."&action=lastest"),
);

$menu = admin_menu($LANG['php_error_log_admin'], $submenu);

$file = PHPCMS_ROOT.'data/php_error_log.xml';
if(!file_exists($file)) showmessage($LANG['log_file_not_existed']);
$xmlstr = file_get_contents($file);
$xmlstr = "<phperror>\n\n$xmlstr</phperror>";
$logarr = xml_str($xmlstr, 'errorentry');

include admin_tpl('errorlog');
?>