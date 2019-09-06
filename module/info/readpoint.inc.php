<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
require PHPCMS_ROOT.'/pay/include/pay.func.php';

$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['illegal_parameters'], $PHP_SITEURL);
$info = $db->get_one("SELECT * FROM ".channel_table('info', $channelid)." WHERE infoid=$itemid ");
$info or showmessage($LANG['current_info_not_exist_or_delete']);
extract($info);
unset($info);

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
point_diff($_username, $readpoint, $title.'(channelid='.$channelid.',infoid='.$infoid.')', $_userid.'-'.$channelid.'-'.$infoid);
header('location:'.$linkurl);
?>