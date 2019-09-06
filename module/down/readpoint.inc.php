<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
require PHPCMS_ROOT.'/pay/include/pay.func.php';

$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['illegal_parameters'], $PHP_SITEURL);
isset($id) or showmessage($LANG['illegal_parameters'], $PHP_SITEURL);

$down = $db->get_one("SELECT * FROM ".channel_table('down', $channelid)." WHERE downid=$itemid ");
$down or showmessage($LANG['download_not_exist_deleted']);
extract($down);
unset($down);

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
point_diff($_username, $readpoint, $title.'(channelid='.$channelid.',downid='.$downid.')', $_userid.'-'.$channelid.'-'.$downid);
header('location:'.$channelurl.'down.php?downid='.$itemid.'&id='.$id);
?>