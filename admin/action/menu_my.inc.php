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
			$db->query("UPDATE ".TABLE_MENU." SET name='$name[$id]',style='$style[$id]',url='$url[$id]',target='$target[$id]',listorder='$listorder[$id]' WHERE menuid=$id");
		}
	}
	if($newname)
	{
		$db->query("insert into ".TABLE_MENU."(position,name,style,url,target,listorder,username) values('admin_mymenu','$newname','$newstyle','$newurl','$newtarget','$newlistorder','$_username')");
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$maxmenuid = 0;
	$menus = array();
	$result = $db->query("SELECT * FROM ".TABLE_MENU." WHERE username='$_username' AND position='admin_mymenu' ORDER BY position,listorder");
	while($r = $db->fetch_array($result))
	{
		$menus[$r['menuid']] = $r;
		$maxmenuid = max($maxmenuid, $r['menuid']);
	}
	$newlistorder = $maxmenuid + 1;
	if(!isset($newtarget)) $newtarget = 'right';
	include admintpl('menu_my');
}
?>