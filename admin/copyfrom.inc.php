<?php
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$referer = isset($referer) ? $referer : '?mod='.$mod.'&file='.$file.'&keyid='.$keyid;
$select = isset($select) ? 1 : 0;
if($select) $pagesize = 50;

switch($action){

case 'update':

	if(is_array($name))
	{
		foreach($name as $id=>$value)
		{
			$db->query("UPDATE ".TABLE_COPYFROM." SET name='$name[$id]',url='$url[$id]',hits='$hits[$id]' WHERE id='$id' and keyid=$keyid");
		}
	}
	showmessage($LANG['operation_success'],$referer);
	break;
	
case 'add':

	$copyfrom = $name.'|'.$url;
	if(update_copyfrom($copyfrom, $keyid))
	{
		showmessage($LANG['operation_success'],$referer);
	}
	else
	{
		showmessage($LANG['operation_failure'],$referer);
	}

	break;

case 'delete':

	if(empty($id))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$ids=is_array($id) ? implode(',', $id) : $id;
	$db->query("DELETE FROM ".TABLE_COPYFROM." WHERE id IN ($ids) AND keyid=$keyid");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$referer);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;

case 'manage':
	if($select)
	{
		$copyfroms = cache_read('copyfrom_'.$keyid.'.php');
	}
	else
	{
		if(!isset($page))
		{
			$page = 1;
			$offset = 0;
		}
		else
		{
			$offset = ($page-1)*$pagesize;
		}
		$ordertypes = array('', 'id desc', 'id asc', 'hits desc', 'hits asc');
		$key = isset($key) ? trim($key) : '';
		$ordertype = (isset($ordertype) && $ordertype > 0 && $ordertype < 4) ? $ordertype : 1;
		$addquery = $key ? " AND name LIKE '%$key%' OR url LIKE '%$key%' " : "";
		$query = "SELECT COUNT(*) AS num FROM ".TABLE_COPYFROM."  WHERE keyid=$keyid $addquery";
		$result = $db->query($query);
		$r = $db->fetch_array($result);
		$number = $r['num'];
		$pages = phppages($number, $page, $pagesize);
		$copyfroms = array();
		$result = $db->query("SELECT * FROM ".TABLE_COPYFROM." WHERE keyid=$keyid $addquery ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r['updatetime'] = date('Y-m-d', $r['updatetime']);
			$copyfroms[] = $r;
		}
		cache_copyfrom($keyid);
	}
	include admintpl('copyfrom');
}
?>