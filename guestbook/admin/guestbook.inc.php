<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = isset($pagesize) && $pagesize<500 ? intval($pagesize) : $PHPCMS['pagesize'];
$action = $action ? $action : 'manage';
$keyid = isset($keyid) ? $keyid : 'phpcms';
$submenu=array(
	array('<font color="#FF0000">'.$LANG['guestbook_manage'].'</font>','?mod='.$mod.'&file='.$file.'&action=manage&passed=1&keyid='.$keyid),
	array('<font color="#0000FF">'.$LANG['guestbook_label_manage'].'</font>','?mod='.$mod.'&file=tag&keyid='.$keyid)
);
$menu = adminmenu($LANG['guestbook_manage'],$submenu);

if($keyid && $keyid != 'phpcms')
{
	$condition = " keyid='$keyid' ";
}
else
{
	$condition = 1;
}
switch($action)
{	
	case 'manage':
	$keyword = isset($keyword) ? $keyword : '';
	$passed = isset($passed) ? $passed : 1;
	$srchtype = isset($srchtype) ? $srchtype : 0;

	require PHPCMS_ROOT."/include/ip.class.php";
	$getip = new Ip;
	$passed = isset($passed) ? $passed : "1";
	if(!isset($page))
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}
	$forward = urlencode("?mod=guestbook&file=guestbook&action=manage&passed=".$passed."&keyid=".$keyid."&page=".$page);
	
	
	$condition .= " AND passed=$passed ";
	if(!empty($keyword))
	{
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);
		switch($srchtype)
		{
		case '0':
			$condition .=" AND title like '%$keyword%' ";
			break;
		case '1':
			$condition .=" AND content like '%$keyword%' ";
			break;
		case '2':
			$condition .=" AND username like '%$keyword%' ";
			break;
		default :
			$condition .=" AND title like '%$keyword%' ";
		}
	}
	$condition .= isset($ip) ? " AND ip='$ip' " : "";

	$query="SELECT COUNT(*) AS num FROM ".TABLE_GUESTBOOK." WHERE $condition";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$pages=phppages($number,$page,$pagesize);

	$query="SELECT * FROM ".TABLE_GUESTBOOK." WHERE $condition ORDER BY gid DESC LIMIT $offset,$pagesize";
	$guestbooks = array();
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$r['adddate']=date("Y-m-d",$r['addtime']);
		$r['addtime']=date("Y-m-d H:i:s",$r['addtime']);
		$r['gip']=$getip->getlocation($r['ip']);
		$guestbooks[]=$r;
	}


	include admintpl('guestbook_manage');
	break;

	case 'delete':

	if(empty($gid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$gids=is_array($gid) ? implode(',',$gid) : $gid;
	$db->query("DELETE FROM ".TABLE_GUESTBOOK." WHERE $condition AND gid IN ($gids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;

	case 'pass':

	if(empty($gid))
	{
		showmessage($LANG['illegal_parameters'],$forward);
	}
	if(!ereg('^[0-1]+$',$passed))
	{
		showmessage($LANG['illegal_parameters'],$forward);
	}
	$gids=is_array($gid) ? implode(',',$gid) : $gid;
	$db->query("UPDATE ".TABLE_GUESTBOOK." SET passed=$passed WHERE $condition AND gid IN ($gids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;

	case 'reply':
	$keyword = isset($keyword) ? $keyword : '';
	$passed = isset($passed) ? $passed : 1;
	$srchtype = isset($srchtype) ? $srchtype : 0;
	if(empty($gid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(isset($submit))
	{
		$db->query("UPDATE ".TABLE_GUESTBOOK." SET reply='$reply',passed='$passed',hidden='$hidden',replyer='$_username',replytime='$PHP_TIME' WHERE gid=$gid ");
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		require PHPCMS_ROOT."/include/ip.class.php";
		$getip = new Ip;
		$referer = urlencode($forward);
		$query = "SELECT * FROM ".TABLE_GUESTBOOK." WHERE gid='$gid'";
		$result = $db->query($query);
		$guestbook = $db->fetch_array($result);
		$gip = $getip->getlocation($guestbook['ip']);
		$guestbook['addtime'] = date("Y-m-d H:i:s",$guestbook['addtime']);
		$guestbook['replytime'] = date("Y-m-d H:i:s",$guestbook['replytime']);
		$guestbook['head'] = $guestbook['head']<10 ? "0".$guestbook['head'] : $guestbook['head'];
		include admintpl('guestbook_reply');
	}

	break;

}
?>