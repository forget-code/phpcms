<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade>0) showmessage($LANG['you_have_no_permission']);

$referer = $referer ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';

if($dosubmit)
{
	foreach($province as $id=>$v)
	{
		if($delete[$id])
		{
			$db->query("delete from ".TABLE_PROVINCE." where provinceid='$id'");
			$db->query("delete from ".TABLE_CITY." where province='$v'");
		}
		else
		{
			$db->query("update ".TABLE_PROVINCE." set province='$v' where provinceid='$id'");
			$db->query("update ".TABLE_CITY." set province='$v' where province='$oldprovince[$id]'");
		}
	}
	if($newprovince)
	{
		$db->query("insert into ".TABLE_PROVINCE."(province) values('$newprovince')");
	}
	showmessage($LANG['operation_success'],$PHP_REFERER);
}
else
{
	$result = $db->query("select * from ".TABLE_PROVINCE." where 1");
	while($r = $db->fetch_array($result))
	{
		$provinces[$r['provinceid']] = $r;
	}
	include admintpl('province');
}
?>