<?php
defined('IN_PHPCMS') or exit('Access Denied');
$pageid = isset($pageid) ? intval($pageid) : 0;
$pageid or showmessage($LANG['page_id_not_null']);
$passed = isset($passed) && $passed == 1 ? 1 : 0;
$db->query("UPDATE ".TABLE_PAGE." SET passed=$passed WHERE pageid=$pageid AND keyid='$keyid' ");
showmessage($LANG['operation_success'], $PHP_REFERER);
?>