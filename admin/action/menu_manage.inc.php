<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	if(!isset($name)) $name = array();
	foreach($name as $id=>$v)
	{
		if(isset($delete[$id]) && $delete[$id])
		{
			$db->query("DELETE FROM ".TABLE_MENU." WHERE menuid=$id");
		}
		else
		{
			$db->query("UPDATE ".TABLE_MENU." SET name='$name[$id]',url='$url[$id]',target='$target[$id]',listorder='$listorder[$id]' WHERE menuid=$id");
		}
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$username = isset($username) ? $username : '';
	$sql = '';
	$sql .= $username ? " username='$username' " : '';
	$sql .= $position ? " position='$position' " : '';
	$sql = $sql ? " WHERE $sql " : '';
	$maxmenuid = 0;
	$menus = array();
	$result = $db->query("SELECT * FROM ".TABLE_MENU." $sql ORDER BY position,listorder");
	while($r = $db->fetch_array($result))
	{
		$menus[$r['menuid']] = $r;
		$maxmenuid = max($maxmenuid, $r['menuid']);
	}
	$newlistorder = $maxmenuid + 1;
	include admintpl('menu');
}
?>