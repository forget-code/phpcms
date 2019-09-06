<?php
require './include/common.inc.php';
require PHPCMS_ROOT.'/member/include/member.class.php';

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$payonline_setting = cache_read('payonline_setting.php');

$head['title'] = $LANG['online_payment_charge'];

$paycenter = getcookie('paycenter');
if($paycenter) $selected[$paycenter] = 'selected';
if(!isset($amount)) $amount = '';


$member = new member($_username);
$memberinfo = $member->get_info();

$contactname = $memberinfo['truename'];
$telephone = $memberinfo['telephone'];
$email = $memberinfo['email'];

include template($mod, 'payonline');
?>