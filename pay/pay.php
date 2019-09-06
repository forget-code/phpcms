<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

if($dosubmit)
{
	$payurl = $paytype.'?amount='.$amount.'&forward='.$forward;
	header("location:".$payurl);
}
else
{
    if(!isset($amount)) $amount = '';
	include template($mod, 'pay');
}
?>