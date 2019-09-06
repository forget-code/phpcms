<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));
require MOD_ROOT.'api/passport_server_ucenter.php';
$avatar = avatar($_userid);
$_touserid = $_touserid ? intval($_touserid) : $_userid;
$uc_html = uc_call("uc_avatar",  array($_touserid));
include template($mod, 'uc_avatar');
?>