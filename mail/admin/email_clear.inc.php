<?php
$db->query("DELETE FROM ".TABLE_MAIL_EMAIL." WHERE addtime<$PHP_TIME-30*24*60*60 AND authcode!='' ");
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>