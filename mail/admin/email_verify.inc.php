<?php

if(!isset($emailid)) showmessage($LANG['illegal_parameters'],'goback');
$emailid = intval($emailid);
$query = "UPDATE ".TABLE_MAIL_EMAIL." SET authcode='' WHERE emailid='$emailid'";
$db->query($query);
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>