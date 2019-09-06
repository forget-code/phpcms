<?php 
require './include/common.inc.php';
require PHPCMS_ROOT.'/pay/include/pay.func.php';

$houseid = isset($houseid) ? intval($houseid) : 0;
$houseid or showmessage($LANG['invalid_Parameters'], $PHP_SITEURL);

$house = $db->get_one("SELECT * FROM ".TABLE_HOUSE." WHERE houseid=$houseid");
$house or showmessage('信息不存在');
extract($house);
unset($house);

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
point_diff($_username, $MOD['readpoint'], $name.'(mod='.$mod.',houseid='.$houseid.')', $_userid.'-'.$mod.'-'.$houseid);
header('location:'.linkurl($linkurl));
?>