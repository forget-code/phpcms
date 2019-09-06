<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
require PHPCMS_ROOT.'/pay/include/pay.func.php';

$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['invalid_Parameters'], $PHP_SITEURL);
$movie = $db->get_one("SELECT * FROM ".channel_table('movie', $channelid)." WHERE movieid=$itemid ");
$movie or showmessage($LANG['movie_not_exist_deleted']);
extract($movie);
unset($movie);

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

point_diff($_username, $readpoint, $title.'(channelid='.$channelid.',movieid='.$movieid.')', $_userid.'-'.$channelid.'-'.$movieid);
header('location:'.$channelurl.'play.php?itemid='.$movieid.'&id='.$id);

?>