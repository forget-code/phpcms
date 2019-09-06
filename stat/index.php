<?php
include './include/common.inc.php';
session_start();
if (!isset($_SESSION['viewstat'])) {
	@extract($MOD);
	$username = isset($username) ? $username : null;
	$passwd = isset($passwd) ? $passwd : null;
	if (empty($username) || empty($passwd)) showmessage($LANG['forbidden_visit']);
	if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_USER'] != $username || $_SERVER['PHP_AUTH_PW'] != $passwd) {
		header('WWW-Authenticate: Basic realm="Statistics:"');
		header('HTTP/1.0 401 Unauthorized');
		echo "<script type='text/javascript'>\r\nwindow.opener=null;\r\nwindow.close();\r\n</script>";
		exit();
	}
	$_SESSION['viewstat'] = 1;
}
include MOD_ROOT.'/admin/stat_realt.inc.php';

$head['title'] = $LANG['statistics'];

include template($mod,'index');
?>