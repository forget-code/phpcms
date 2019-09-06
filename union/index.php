<?php
require './include/common.inc.php';

if($PHP_QUERYSTRING)
{
	$userid = intval($PHP_QUERYSTRING);
	$r = $db->get_one("SELECT username FROM ".TABLE_MEMBER." WHERE userid=$userid");
	if($r)
	{
		$ftime = $PHP_TIME - 3600*24;
		$result = $db->query("SELECT visitid FROM ".TABLE_UNION_VISIT." WHERE userid=$userid AND visitip='$PHP_IP' AND visittime>$ftime");
		if($db->num_rows($result) == 0)
		{
			$type = $MOD['visitgettype'];
			$number = $MOD['visitgetnumber'];
			$username = $r['username'];
			include PHPCMS_ROOT.'/pay/include/pay.func.php';
			switch($type)
			{
				case 'point':
					point_add($username, $number, 'union');
					break;
				case 'credit':
					credit_add($username, $number, 'union');
					break;
				case 'money':
					money_add($username, $number, 'union');
			}
			$db->query("UPDATE ".TABLE_UNION." SET visits=visits+1 WHERE userid=$userid");
			if($db->affected_rows())
			{
				$db->query("INSERT INTO ".TABLE_UNION_VISIT."(userid,visittime,visitip,referer) VALUES('$userid','$PHP_TIME','$PHP_IP','$PHP_REFERER')");
				$union_visitid = $db->insert_id();
				$cookietime = $PHP_TIME + $MOD['keeptime'];
				mkcookie('union_visitid', $union_visitid, $cookietime);
				mkcookie('union_userid', $userid, $cookietime);
			}
		}
	}
}
if(!$url) $url = $MOD['forward'] ? $MOD['forward'] : $PHP_SITEURL;
header('location:'.$url);
?>