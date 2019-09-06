<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function cache_department()
{
	global $db;
	$departments = array();
	$result = $db->query("select * from ".TABLE_ASK_DEPARTMENT." order by listorder");
	while($r = $db->fetch_array($result))
	{
		$departments[$r['departmentid']] = $r;
	}
	return cache_write('ask_department.php', $departments);
}
?>