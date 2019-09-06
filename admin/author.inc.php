<?php
defined('IN_PHPCMS') or exit('Access Denied');
isset($keyid) or showmessage($LANG['illegal_parameters']);
$action = $action ? $action : 'manage';
$referer = isset($referer) ? $referer : '?mod='.$mod.'&file='.$file.'&keyid='.$keyid;
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$select = isset($select) ? 1 : 0;
if($select) $pagesize = 50;
switch($action){

case 'update':

	if(is_array($name))
	{
		foreach($name as $id=>$value)
		{
			$db->query("UPDATE ".TABLE_AUTHOR." SET name='$name[$id]',note='$note[$id]',items='$items[$id]' WHERE id='$id' and keyid='$keyid' ");
		}
	}
	showmessage($LANG['operation_success'],$referer);
	break;
	
case 'add':

	if(update_author($author, $keyid, $note))
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
	$db->query("DELETE FROM ".TABLE_AUTHOR." WHERE id IN ($ids) AND keyid='$keyid'");
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
		$authors = cache_read('author_'.$keyid.'.php');
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
		$ordertypes = array('', 'id desc', 'id asc', 'items desc', 'items asc');
		$key = isset($key) ? trim($key) : '';
		$ordertype = (isset($ordertype) && $ordertype > 0 && $ordertype < 4) ? $ordertype : 1;
		$addquery = $key ? " AND author LIKE '%$key%' " : '';
		$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_AUTHOR."  WHERE keyid='$keyid' $addquery");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$author = array();
		$result = $db->query("SELECT * FROM ".TABLE_AUTHOR." WHERE keyid='$keyid' $addquery ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r['updatetime'] = date('Y-m-d', $r['updatetime']);
			$authors[] = $r;
		}
		cache_author($keyid);
	}
	include admintpl('author');
}
?>