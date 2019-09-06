<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array(
	array("","?mod=$mod&file=digg_list"),
);
$menu = adminmenu("顶一下模块设置",$submenu);

if($dosubmit)
{
	module_setting($mod, $digg);
	showmessage($LANG['save_setting_success'],$PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));
    include admintpl('setting');
}
?>
