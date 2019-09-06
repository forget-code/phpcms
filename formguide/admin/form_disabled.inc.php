<?php
defined('IN_PHPCMS') or exit('Access Denied');
$forward = $forward ? $forward : $PHP_REFERER;
if(!isset($formid)) showmessage($LANG['illegal_parameters']);
$formid = intval($formid);
$db->query('UPDATE '.TABLE_FORMGUIDE.' SET disabled = NOT disabled WHERE formid='.$formid);
showmessage($LANG['operation_success'], $forward);
?>