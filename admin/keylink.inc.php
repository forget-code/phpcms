<?php
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$referer = isset($referer) ? $referer : '?mod='.$mod.'&file='.$file;

switch($action){

case 'update':

	if(is_array($linktext))
	{
		foreach($linktext as $k=>$v)
		{
			if(empty($linktext[$k]) || empty($linkurl[$k]))
			{
				showmessage($LANG['related_word_link_not_null']);
			}
			$db->query("UPDATE ".TABLE_KEYLINK." SET linktext='$linktext[$k]',linkurl='$linkurl[$k]',passed='$passed[$k]' WHERE linkid='$k'");
		}
	}
	showmessage($LANG['related_link_update_success'],$referer);
	break;
	
case 'add':

	if(empty($linktext) || empty($linkurl))
	{
		showmessage($LANG['related_word_link_not_null']);
	}
	$linktext = trim($linktext);
	$linkurl = trim($linkurl);
	$result=$db->query("SELECT linktext FROM ".TABLE_KEYLINK." WHERE linktext='$linktext'");
	if($db->num_rows($result))
	{
		showmessage($LANG['link_exsited']);
	}
	$db->query("INSERT INTO ".TABLE_KEYLINK." (linktext,linkurl) VALUES ('$linktext','$linkurl')");

	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'], $referer);
	}
	else
	{
		showmessage($LANG['operation_failure'], $referer);
	}

	break;

case 'delete':

	if(empty($linkid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$linkids=is_array($linkid) ? implode(',',$linkid) : $linkid;
	$db->query("DELETE FROM ".TABLE_KEYLINK." WHERE linkid IN ($linkids)");
	if($db->affected_rows()>0)
	{
		cache_update('keylink');
		showmessage($LANG['operation_success'],$referer);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;

case 'manage':

	if(!isset($page))
	{
		$page = 1;
		$offset = 0;
	}
	else
	{
		$offset = ($page-1)*$pagesize;
	}
	$keywords = isset($keywords) ? trim($keywords) : '';
	$addquery = '';
	$addquery = $keywords ? " AND linktext LIKE '%$keywords%' OR linkurl LIKE '%$keywords%' " : '';
	$r = $db->get_one("SELECT COUNT(linkid) AS num FROM ".TABLE_KEYLINK." WHERE 1 $addquery");
	$number = $r['num'];
	$pages = phppages($number, $page, $pagesize);
	$result=$db->query("SELECT * FROM ".TABLE_KEYLINK." WHERE 1 $addquery ORDER BY linkid DESC LIMIT $offset,$pagesize");
	$keylinks = array();
	while($r=$db->fetch_array($result))
	{
		$keylinks[]=$r;
	}
	cache_update('keylink');
	include admintpl('keylink');
}
?>