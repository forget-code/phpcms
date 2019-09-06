<?php
defined('IN_PHPCMS') or exit('Access Denied');
@set_time_limit(600);
if(isset($action) && strpos($action, ',') && !$pernum)
{
	$actions=explode(',',$action);
	$action=$actions[0];
	unset($actions[0]);
	$actions=implode(',',$actions);
	$referer='?file='.$file.'&action='.$actions;
}
$referer = $referer ? $referer : "?file=templates";
$mod = 'yp';
$action = isset($action) ? $action : showmessage('非法参数');
switch($action)
{
	case 'article':
		$table = TABLE_YP_ARTICLE;
		$label_alt = $LANG['label_article'];
		$flagid = 'articleid';
	break;
	case 'product':
		$table = TABLE_YP_PRODUCT;
		$label_alt = $LANG['label_product'];
		$flagid = 'productid';
	break;
	case 'job':
		$table = TABLE_YP_JOB;
		$label_alt = $LANG['label_job'];
		$flagid = 'jobid';
	break;
	case 'buy':
		$table = TABLE_YP_BUY;
		$label_alt = $LANG['label_buy'];
		$flagid = 'productid';
	break;
	case 'sales':
		$table = TABLE_YP_SALES;
		$label_alt = $LANG['label_sales'];
		$flagid = 'productid';
	break;
}
$tmpskindir = $skindir;
if(!isset($fid))
{
	$r=$db->get_one("select min($flagid) as fid from ".$table." WHERE username='$_username'");
	$fid=$r['fid'];
	$fid = $fid ? $fid : 0;
}
if(!isset($tid))
{
	$r=$db->get_one("select max($flagid) as tid from ".$table." WHERE username='$_username'");
	$tid=$r['tid'];
	$tid = $tid ? $tid : 1;
}
$pernum = 50;
if($fid+$pernum < $tid)
{
	$query = "select $flagid from ".$table." WHERE status>=3 and $flagid>=$fid AND username='$_username' order by $flagid limit 0,$pernum ";
	$result = $db->query($query);
	if($db->affected_rows($result) > 0)
	{
		while($r = $db->fetch_array($result))
		{
			$labelid = $r[$flagid];
			$skindir = $tmpskindir;
			createhtml_show($table,$action,$labelid,$flagid);
		}
	}
	else
	{
		$labelid = $fid + $pernum;
	}
}
elseif($fid<=$tid)
{
	$query = "select $flagid from ".$table." WHERE status>=3 and $flagid>=$fid AND username='$_username' order by $flagid limit 0,$pernum ";
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		$labelid = $r[$flagid];
		$skindir = $tmpskindir; 
		createhtml_show($table,$action,$labelid,$flagid);
	}
	showmessage($label_alt.$LANG['html_success'],$referer);
}
else
{
	showmessage($label_alt.$LANG['html_success'],$referer);
}
if($action=='product' && !$fid)	$action = 'buy';
$referer='?file='.$file.'&action='.$action.'&fid='.$labelid.'&tid='.$tid.'&pernum='.$pernum;
showmessage('ID '.$LANG['from'].$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$label_alt.$LANG['html_success'], $referer);
?>