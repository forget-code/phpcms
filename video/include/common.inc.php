<?php 
$mod = 'video';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));

require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';
require MOD_ROOT.'include/global.func.php';
require_once MOD_ROOT.'include/output.func.php';
require_once 'form.class.php';
$C = subcat('video');
$modelid = $M['modelid'];
$video_table = DB_PRE.$mod;
$video_data_table = DB_PRE.$mod.'_data';
$urlrule = $URLRULE[$M['categoryUrlRuleid']];
$urlrule = str_replace('{$catid}',$catid,$urlrule);
if(strpos($urlrule, '|'))
{
	$urlrules = explode('|', $urlrule);
	$urlrule = $M['url'].$urlrules[0].'|'.$M['url'].$urlrules[1];
}
else
{
	$urlrule = $M['url'].$urlrule;
}
$arr_category = subcat('video',0);
$menu_selectid = $M['menu_selectid'];
?>