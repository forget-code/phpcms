<?php
defined('IN_PHPCMS') or exit('Access Denied');
include(PHPCMS_ROOT."/{$mod}/admin/menu.inc.php");
include(PHPCMS_ROOT.'/include/tree.class.php');
$action = !empty($action) ? $action : 'manage';
$curUri = "?$PHP_QUERYSTRING";
$submenu = $menu[$mod];
for ($i = 0; $i < count($submenu); $i++)
{
	if ($submenu[$i][1] == $curUri)
	{
		$curpos = "{$modtitle[$mod]}&gt;&gt;{$submenu[$i][0]}";
		$title = $submenu[$i][0];
		break;
	}
	else
	{
		$curpos = $title = $modtitle[$mod];
	}
}
$menu = adminmenu($modtitle[$mod], $submenu);
include admintpl('header');
include($file. '_' . $action. '.inc.php');
include admintpl($file. '_' . $action);
?>