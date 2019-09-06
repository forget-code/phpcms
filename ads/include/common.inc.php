<?php 
$mod = 'ads';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';
require MOD_ROOT.'include/global.func.php';

require MOD_ROOT.'include/ads_place.class.php';
require MOD_ROOT.'include/ads.class.php';
$GROUP = cache_read('member_group.php');
$c_ads = new ads();
$place = new ads_place();
$head['title'] = $M['name'];
$head['keyword'] = $M['keyword'];
$head['description'] = $M['description'];
if($_userid)
{
	$_extend_group = $db->select("SELECT groupid FROM `".DB_PRE."member_group_extend` WHERE `userid`=$_userid");
}
?>