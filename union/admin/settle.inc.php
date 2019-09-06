<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$u = $db->get_one("SELECT * FROM ".TABLE_UNION." WHERE userid=$userid");

    if($settleexpendamount <= 0) showmessage('用户消费金额为0，不需要结算！');
	if($settleexpendamount > $u['settleexpendamount']) showmessage('非法操作！');

	$settleexpendamount = round(floatval($settleexpendamount), 2);
	$settleamount = round($settleexpendamount*$profitmargin/100, 2);

	$db->query("INSERT INTO ".TABLE_UNION_PAY."(userid,alipay,amount,expendamount,profitmargin,inputer,addtime,ip) VALUES('$userid','$alipay','$settleamount','$settleexpendamount','$profitmargin','$_username','$PHP_TIME','$PHP_IP')");
    $db->query("UPDATE ".TABLE_UNION." SET totalexpendamount=totalexpendamount+$settleexpendamount,totalpayamount=totalpayamount+$settleamount,lastpayamount=$settleamount,lastpaytime='$PHP_TIME',settleexpendamount=settleexpendamount-$settleexpendamount WHERE userid=$userid");
    showmessage('操作成功！', $PHP_REFERER);
}
else
{
	$u = $db->get_one("SELECT * FROM ".TABLE_UNION." WHERE userid=$userid");
	$m = $db->get_one("SELECT m.lastlogintime,i.* FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid AND m.userid=$userid");
    $u = array_merge($u, $m);
	extract($u);

	$allexpendamount = $totalexpendamount + $settleexpendamount;
	$settleamount = round($settleexpendamount*$profitmargin/100, 2);
	$lastpaydate = $lastpaytime ? date('Y-m-d', $lastpaytime) : '';
	$lastlogintime = date('Y-m-d H:i:s', $lastlogintime);

	include admintpl('settle');
}
?>