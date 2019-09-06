<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
require PHPCMS_ROOT.'/pay/include/pay.func.php';

$itemid = isset($itemid) ? intval($itemid) : 0;
$itemid or showmessage($LANG['invalid_Parameters'], $PHP_SITEURL);
$article = $db->get_one("SELECT * FROM ".channel_table('article', $channelid)." WHERE articleid=$itemid ");
$article or showmessage($LANG['article_not_exists']);
extract($article);
unset($article);

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
point_diff($_username, $readpoint, $title.'(channelid='.$channelid.',articleid='.$articleid.')', $_userid.'-'.$channelid.'-'.$articleid);
header('location:'.linkurl($linkurl));
?>