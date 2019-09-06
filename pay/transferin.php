<?php
require './include/common.inc.php';

if(!$MOD['enabletransferin']) showmessage($LANG['not_enable_transferin'], $PHP_REFERER);

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$sameserver = 0;
if($MOD['dbfrom'])
{
	require PHPCMS_ROOT.'/config.inc.php';
	if($CONFIG['dbhost'] == $MOD['dbhost'] && $CONFIG['dbuser'] == $MOD['dbuser'] && $CONFIG['dbpw'] == $MOD['dbpw'])
	{
		$sameserver = 1;
		$sqldb = &$db;
	}
	else
	{
		$sqldb = new db_mysql;
		$sqldb->connect($MOD['dbhost'], $MOD['dbuser'], $MOD['dbpw'], $MOD['dbname']);
	}
}
else
{
	$sqldb = &$db;
}
$fields = array();
if($MOD['field_point']) $fields[] = $MOD['field_point'].' AS point';
if($MOD['field_credit']) $fields[] = $MOD['field_credit'].' AS credit';
if($MOD['field_money']) $fields[] = $MOD['field_money'].' AS money';
$selectfields = implode(',', $fields);
$point_field = $MOD['field_point'];
$credit_field = $MOD['field_credit'];
$money_field = $MOD['field_money'];
$username = $MOD['field_username'];
$table = $MOD['table'];

if($sameserver) $sqldb->select_db($MOD['dbname']);
$r = $sqldb->get_one("SELECT $selectfields FROM $table WHERE $username='$_username' LIMIT 0,1");
if(!$r) showmessage("$_username is not exists !");
extract($r);

if($dosubmit)
{
	$number = intval($number);
	if($number <= 0) showmessage($LANG['illegal_parameters'], $PHP_REFERER);
	if($type == 'money')
	{
		if($money < $number) showmessage($LANG['money_transfer_in_not_enough'], $PHP_REFERER);
		$money = $money - $number;
		$sqldb->query("UPDATE $table SET $money_field=$money WHERE $username='$_username'");
		if($sameserver) $db->select_db($CONFIG['dbname']);
		money_add($_username, $number,$LANG['money_transfer_in']);
	}
	elseif($type == 'point')
	{
		if($point < $number) showmessage($LANG['point_transfer_in_not_enough'], $PHP_REFERER);
		$point = $point - $number;
		$sqldb->query("UPDATE $table SET $point_field=$point WHERE $username='$_username'");
		if($sameserver) $db->select_db($CONFIG['dbname']);
		point_add($_username, $number,$LANG['point_transfer_in']);
	}
	elseif($type == 'credit')
	{
		if($credit < $number) showmessage($LANG['credit_transfer_in_not_enough'], $PHP_REFERER);
		$credit = $credit - $number;
		$sqldb->query("UPDATE $table SET $credit_field=$credit WHERE $username='$_username'");
		if($sameserver) $db->select_db($CONFIG['dbname']);
		credit_add($_username, $number,$LANG['credit_transfer_in']);
	}
	showmessage($LANG['operation_success'] , $forward);
}
else
{
	if($sameserver) $db->select_db($CONFIG['dbname']);
	$typenum = count($fields);

	$head['title'] = $LANG['transferin'];

	include template($mod, 'transferin');
}
?>