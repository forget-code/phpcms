<?php
defined('IN_PHPCMS') or exit('Access Denied');
isset($keyid) or showmessage($LANG['illegal_parameters']);
$action = $action ? $action : 'manage';
$referer = isset($referer) ? $referer : '?mod='.$mod.'&file='.$file.'&keyid='.$keyid;
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$select = isset($select) ? 1 : 0;
if($select) $pagesize = 50;

switch($action)
{

case 'update':

	if(is_array($keywords))
	{
		foreach($keywords as $id=>$value)
		{
			$db->query("UPDATE ".TABLE_KEYWORDS." SET keywords='$keywords[$id]',hits='$hits[$id]' WHERE id='$id' and keyid='$keyid'");
		}
	}
	showmessage($LANG['operation_success'],$referer);
	break;
	
case 'add':

	if(update_keywords($keywords, $keyid))
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
	$db->query("DELETE FROM ".TABLE_KEYWORDS." WHERE id IN ($ids) AND keyid='$keyid'");
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
		$keywords = cache_read('keywords_'.$keyid.'.php');
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
		$addquery = $key ? " AND keywords LIKE '%$key%' " : '';
		$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_KEYWORDS."  WHERE keyid='$keyid' $addquery");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$keywords = array();
		$result = $db->query("SELECT * FROM ".TABLE_KEYWORDS." WHERE keyid='$keyid' $addquery ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r['updatetime'] = date('Y-m-d', $r['updatetime']);
			$keywords[] = $r;
		}
		cache_keywords($keyid);
	}
	include admintpl('keywords');
}
?>