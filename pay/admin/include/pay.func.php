<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function pay_type()
{
	global $db;
	$types = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_TYPE." ORDER BY listorder");
	while($r = $db->fetch_array($result))
	{
		$types[$r['typeid']] = $r;
	}
	$db->free_result($result);
	return $types;
}
?>