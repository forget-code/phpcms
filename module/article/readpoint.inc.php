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

$CAT = cache_read('category_'.$catid.'.php');

point_diff($readpoint, $title.'(articleid='.$articleid.')');
$readtime = $CAT['defaultchargetype'] ? 0 : $PHP_TIME+3600*24*365;
mkcookie('article_'.$articleid, 1, $readtime);

header('location:'.linkurl($linkurl));
?>