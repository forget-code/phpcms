<?php
defined('IN_PHPCMS') or exit('Access Denied');

$union_visitid = intval(getcookie('union_visitid'));
$union_userid = intval(getcookie('union_userid'));

if($union_visitid && $union_userid)
{
	$r = $db->get_one("SELECT username FROM ".TABLE_UNION." WHERE userid=$union_userid");
	if($r)
	{
		$db->query("UPDATE ".TABLE_UNION." SET registers=registers+1 WHERE userid=$union_userid");
		if($db->affected_rows())
		{
			$db->query("UPDATE ".TABLE_UNION_VISIT." SET regusername='$username',regtime='$PHP_TIME' WHERE visitid=$union_visitid");
			$db->query("UPDATE ".TABLE_MEMBER." SET introducer=$union_userid WHERE userid=$userid");
			$type = $MOD['reggettype'];
			$number = $MOD['reggetnumber'];
			$username = $r['username'];
			require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
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
		}
	}
}
?>