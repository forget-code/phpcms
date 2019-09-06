<?php
defined('IN_PHPCMS') or exit('Access Denied');
@extract($MOD);
include(PHPCMS_ROOT."/{$mod}/admin/menu.inc.php");
include(PHPCMS_ROOT.'/include/tree.class.php');
$curUri = "?mod=$mod&file=$file&action=$action";
include(MOD_ROOT.'/include/engine.func.php');
$tree = new tree();
if (strpos($action, '_') !== false)
{
	$prefix = substr($action, 0, strpos($action, '_'));
}
else
{
	$prefix = $action;
}
switch ($prefix)
{
	case 'realt':
		$submenu = array(
		array($LANG['comprehensive'],"?mod=$mod&file=$mod&action=realt"),
		array($LANG['online_visitors'],"?mod=$mod&file=$mod&action=realt_1"),
		array($LANG['recently_visitors'],"?mod=$mod&file=$mod&action=realt_2"),
		array($LANG['recently_5minutes'],"?mod=$mod&file=$mod&action=realt_3"),
		array($LANG['recently_10minutes'],"?mod=$mod&file=$mod&action=realt_4"),
		array($LANG['recently_30minutes'],"?mod=$mod&file=$mod&action=realt_5"),
		array($LANG['recently_1hours'],"?mod=$mod&file=$mod&action=realt_6"));
		break;
	case 'flux':
		$submenu = array(
		array($LANG['analysis_per_hour'], "?mod=$mod&file=$mod&action=flux"),
		array($LANG['analysis_per_day'], "?mod=$mod&file=$mod&action=flux_1"),
		array($LANG['analysis_per_week'],"?mod=$mod&file=$mod&action=flux_2"),
		array($LANG['analysis_per_month'],"?mod=$mod&file=$mod&action=flux_3"));
		break;
	case 'ivsit':
		$submenu = array(
		array($LANG['stat_by_frequency'],"?mod=$mod&file=$mod&action=ivsit"),
		array($LANG['stat_by_referral'],"?mod=$mod&file=$mod&action=ivsit_1"),
		array($LANG['stat_by_page'],"?mod=$mod&file=$mod&action=ivsit_2"),
		array($LANG['stat_by_engine'],"?mod=$mod&file=$mod&action=ivsit_3"),
		array($LANG['stat_by_keyword'],"?mod=$mod&file=$mod&action=ivsit_4"),
		array($LANG['stat_by_geographical'],"?mod=$mod&file=$mod&action=ivsit_5"));
		break;
	case 'client':
		$submenu = array(
		array($LANG['operating_system'],"?mod=$mod&file=$mod&action=client"),
		array($LANG['analysis_of_browser'],"?mod=$mod&file=$mod&action=client_1"),
		array($LANG['system_language'],"?mod=$mod&file=$mod&action=client_2"),
		array($LANG['screen_size'],"?mod=$mod&file=$mod&action=client_3"),
		array($LANG['screen_color'],"?mod=$mod&file=$mod&action=client_4"),
		array($LANG['alexa_toolbar'],"?mod=$mod&file=$mod&action=client_5"));
		break;
	default:
		$submenu = array(
		array($LANG['real_time'],"?mod=$mod&file=$mod&action=realt"),
		array($LANG['traffic_ analysis'],"?mod=$mod&file=$mod&action=flux"),
		array($LANG['statistics'],"?mod=$mod&file=$mod&action=ivsit"),
		array($LANG['client_analysis'],"?mod=$mod&file=$mod&action=client"),
		array($LANG['custom_analysis'],"?mod=$mod&file=$mod&action=custom"),
		array($LANG['tracking_visitors'],"?mod=$mod&file=$mod&action=track"));
}
for ($i = 0; $i < count($menu[$mod]); $i++) {
	if (strpos($menu[$mod][$i][1], $prefix) !== false) {
		$curpos = $title = $menu[$mod][$i][0];
		break;
	}
}
if (in_array($prefix, array('realt', 'flux', 'ivsit', 'client')))
{
	$curpos .= "&nbsp;&gt;&gt;&nbsp;";
	for ($i = 0; $i < count($submenu); $i++)
	{
		if (substr($submenu[$i][1], strrpos($submenu[$i][1], '=') + 1) == $action)
		{
			$title = $submenu[$i][0];
			break;
		}
	}
	$curpos .= $title;
}
$menu = adminmenu($modtitle[$mod], $submenu);
include admintpl('header');
include($file. '_' . $action. '.inc.php');
if ($prefix == 'realt' && $action != 'realt')
{
	include admintpl($file. '_' . $prefix . '_all');
}
else
{
	include admintpl($file. '_' . $action);
}
?>