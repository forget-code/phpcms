<?php
require './include/common.inc.php';

$asks = array();
foreach($departments as $departmentid=>$department)
{
	$result = $db->query("select * from ".TABLE_ASK." where username='$_username' AND departmentid=$departmentid order by askid desc limit 0,5");
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = date('Y-m-d h:i', $r['addtime']);
		$r['department'] = $departments[$r['departmentid']]['department'];
		$r['stat'] = $STATUS[$r['status']];
		$asks[$departmentid][] = $r;
	}
}

$head['title'] = $LANG['consultation'];

include template($mod, 'index');
?>