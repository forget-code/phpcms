<?php
defined('IN_PHPCMS') or exit('Access Denied');

$passed = intval($passed);
$userid = intval($userid);

$db->query("UPDATE ".TABLE_UNION." SET passed=$passed WHERE userid=$userid");
showmessage('操作成功！', $PHP_REFERER);
?>