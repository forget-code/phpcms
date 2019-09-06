<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!isset($v_oid) || !isset($v_pstatus) || !isset($v_amount) || !isset($v_moneytype)) showmessage($LANG['illegal_parameters']);

$orderid = $v_oid;
$amount = $v_amount;

$md5string = strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$keycode));
if($v_md5str == $md5string)
{
	if($v_pstatus == '20')
	{
		$info = dopay($v_oid, $v_amount, $v_pmode);
        if($info)
		{
			$paystatus = 1;
			extract($info, EXTR_OVERWRITE);
		}
	}
	else
	{
		$paystatus = 2;
	}
}
else
{
	$paystatus = 0;
}
?>