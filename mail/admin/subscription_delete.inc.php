<?php

$mailid= intval($mailid);
$db->query("DELETE FROM ".TABLE_MAIL." WHERE mailid=$mailid");
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>