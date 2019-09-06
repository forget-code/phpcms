<?php
define('C_ROOT', substr(dirname(__FILE__), 0, -14));
require C_ROOT.'/include/common.inc.php';
if(!$_userid) showmessage("你没有登陆");

$tmp = $_COOKIE['tmp'];
$tmp_url = $_COOKIE['tmp_url'];

define("TMP_PATH", $tmp);
define("TMP_URL", $tmp_url);
define("FILENAME_CHECK",'/(jpg|jpeg|gif|png|bmp)$/i');
?>