<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['point_buy_setting'], '?mod='.$mod.'&file=point'),
	array($LANG['period_of_validity_setting'], '?mod='.$mod.'&file=time'),
	array($LANG['credit2point_setting'], '?mod='.$mod.'&file=credit2point'),
	array($LANG['credit2time_setting'], '?mod='.$mod.'&file=credit2time'),
);
$menu = adminmenu($LANG['point_and_period_of_validity_setting'], $submenu);

if($dosubmit)
{
	if(!isset($price)) $price = array();
	foreach($price as $id=>$v)
	{
		if(isset($delete[$id]) && $delete[$id])
		{
			$db->query("DELETE FROM ".TABLE_PAY_PRICE." WHERE id=$id");
		}
		else
		{
			$db->query("UPDATE ".TABLE_PAY_PRICE." SET price='$price[$id]',time='$time[$id]',unit='$unit[$id]' WHERE id=$id");
		}
	}
	if($newprice)
	{
		$db->query("INSERT INTO ".TABLE_PAY_PRICE."(type,price,time,unit) VALUES(3,'$newprice','$newtime','$newunit')");
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$times = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_PRICE." WHERE type=3 ORDER BY id");
	while($r = $db->fetch_array($result))
	{
		$times[$r['id']] = $r;
	}
	include admintpl('credit2time');
}
?>