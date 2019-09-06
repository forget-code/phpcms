<?php
defined('IN_PHPCMS') or exit('Access Denied');

$u = $db->get_one("SELECT * FROM ".TABLE_UNION." WHERE userid=$_userid");
extract($u);

$allexpendamount = $totalexpendamount + $settleexpendamount;
$settleamount = round($settleexpendamount*$profitmargin/100, 2);
$lastpaydate = $lastpaytime ? date('Y-m-d', $lastpaytime) : '';

$head['title'] = '推广联盟统计信息';

include template($mod, 'stats');
?>