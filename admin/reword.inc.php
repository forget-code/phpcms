<?php

defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$referer = isset($referer) ? $referer : '?mod='.$mod.'&file='.$file;

switch($action){

case 'update':

	if(is_array($word))
	{
		foreach($word as $k=>$v)
		{
			if(empty($word[$id]))
			{
				showmessage($LANG['filter_word_not_null']);
			}
			$word[$id] = trim($word[$id]);
			$replacement[$id] = trim($replacement[$id]);
			if($word[$id] == $replacement[$id])
			{
				showmessage($LANG['filter_word_not_same_as_replace_word'],$referer);
			}
			$db->query("UPDATE ".TABLE_REWORD." SET word='$word[$k]',replacement='$replacement[$k]',passed='$passed[$k]' WHERE rid='$k' ");
		}
	}
	showmessage($LANG['operation_success'],$referer);
	break;
	
case 'add':

	if(empty($word))
	{
		showmessage($LANG['filter_word_not_null']);
	}
	$word = trim($word);
	$replacement = trim($replacement);
	if($word == $replacement)
	{
		showmessage($LANG['filter_word_not_same_as_replace_word']);
	}
	$result = $db->query("SELECT word FROM ".TABLE_REWORD." WHERE word='$word'");
	if($db->num_rows($result))
	{
		showmessage($LANG['filter_word_exist']);
	}
	$db->query("INSERT INTO ".TABLE_REWORD." (word,replacement) VALUES ('$word','$replacement')");
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

	if(empty($rid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$rids=is_array($rid) ? implode(',', $rid) : $rid;
	$db->query("DELETE FROM ".TABLE_REWORD." WHERE rid IN ($rids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['delete_success'],$referer);
	}
	else
	{
		showmessage($LANG['delete_fail']);
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
	$addquery .= $keywords ? " AND word LIKE '%$keywords%' OR replacement LIKE '%$keywords%' " : '';
	$r = $db->get_one("SELECT COUNT(rid) AS num FROM ".TABLE_REWORD." WHERE 1 $addquery");
	$number = $r['num'];
	$pages = phppages($number, $page, $pagesize);
	$result = $db->query("SELECT * FROM ".TABLE_REWORD." WHERE 1 $addquery ORDER BY rid DESC LIMIT $offset,$pagesize");
	$rewords = array();
	while($r = $db->fetch_array($result))
	{
		$rewords[] = $r;
	}
	cache_update('reword');
	include admintpl('reword');
}
?>