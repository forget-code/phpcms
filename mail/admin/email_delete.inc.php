<?php

$emailid= intval($emailid);
$db->query("DELETE FROM ".TABLE_MAIL_EMAIL." WHERE emailid=$emailid");
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>