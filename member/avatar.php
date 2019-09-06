<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));
require MOD_ROOT.'api/passport_server_ucenter.php';
$avatar = avatar($_userid);
$uc_html = uc_call("uc_avatar",  array($_userid));
include template($mod, 'uc_avatar');
?>