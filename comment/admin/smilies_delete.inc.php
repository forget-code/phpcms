<?php
defined('IN_PHPCMS') or exit('Access Denied');
$referer = "?mod=$mod&file=$file&action=manage";

if(!$smilesrc) showmessage($LANG['illegal_parameters'],$referer);
$smilesrc = PHPCMS_ROOT.'/comment/smilies/'.$smilesrc;
if(!file_exists($smilesrc)) showmessage($LANG['smile_not_exist'],$referer);
else @unlink($smilesrc);
showmessage($LANG['operation_success'],$referer);
?>