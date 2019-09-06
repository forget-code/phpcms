<?php
	defined('IN_PHPCMS') or exit('Access Denied');
	define('MOD_ROOT', PHPCMS_ROOT.''.$mod.'/');
	require MOD_ROOT.'include/global.func.php';
	require MOD_ROOT.'admin/include/space_admin.class.php';
	$space_admin = new space_admin();
?>