<?php
require './include/common.inc.php';

if($PHP_QUERYSTRING)
{
	$userid = intval($PHP_QUERYSTRING);
	$r = $db->get_one("SELECT username FROM ".TABLE_MEMBER." WHERE userid=$userid");
	if($r)
	{
		$username = $r['username'];
		@extract($MOD);
		$stop = 0;
		if($PHP_REFERER && $domain)
		{
			$arrTmp = explode(',', $domain);
			foreach($arrTmp as $domain)
			{
				if(strpos($PHP_REFERER, $domain) !== FALSE)
				{
					$stop = 1;
					break;
				}
			}
		}
		if($stop == 0)
		{
			$ftime = $PHP_TIME - 3600*24;
			$result = $db->query("SELECT billid FROM ".TABLE_BILL." WHERE userid=$userid AND ip='$PHP_IP' AND addtime>$ftime");
			if($db->num_rows($result) == 0)
			{
				$adddate = date('Y-m-d', $PHP_TIME);
				$db->query("INSERT INTO ".TABLE_BILL." (`userid`,`ip`,`refurl`,`type`,`number`,`addtime`,`adddate`) VALUES('$userid','$PHP_IP','$PHP_REFERER','$type','$number','$PHP_TIME','$adddate')");
				if ($db->affected_rows() > 0)
				{
					if(!isset($type))
					{
						$type = 'points';
					}
					if(!isset($number))
					{
						$number = 0;
					}
					include PHPCMS_ROOT.'/pay/include/pay.func.php';
					switch($type)
					{
						case 'points':
							point_add($username, $number, 'bill');
							break;
						case 'days':
							time_add($username, $number, 'bill');
							break;
						case 'money':
							money_add($username, $number, 'bill');
							break;
						case 'credit':
							credit_add($username, $number, 'bill');
							break;
					}
				}
			}
		}
	}
}
header("location:$PHP_SITEURL");
?>