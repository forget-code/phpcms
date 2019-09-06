<?php
defined('IN_PHPCMS') or exit('Access Denied');
include(PHPCMS_ROOT."/{$mod}/admin/menu.inc.php");
include(PHPCMS_ROOT.'/include/tree.class.php');
$tree = new tree();
$module = $mod;
$submenu = $menu[$mod];
$menu = adminmenu($modtitle[$mod], $submenu);
$filename = array();
$menutitle = array();
for ($i = 0; $i < count($submenu); $i++)
{
	parse_str($submenu[$i][1]);
	$filename[] = $action;
	$menutitle[] = $submenu[$i][0];
}
parse_str($_SERVER['REQUEST_URI']);
for ($i = 0; $i < count($filename); $i++)
{
	if (isset($action) && $action == $filename[$i])
	{
		$fid = $i;
		break;
	}
}
if (!isset($fid))
{
	showmessage($LANG['illegal_action'], $PHP_REFERER);
}
include admintpl('header');
echo "$menu";
echo "<div style='text-align:left'>{$LANG['current_position']}:{$modtitle[$mod]}&nbsp;&gt;&gt;&nbsp;{$menutitle[$fid]}</div>";
include($file. '_' . $action. '.inc.php');
include admintpl($file. '_' . $action);
echo '</body></html>';
?>