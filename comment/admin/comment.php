<?php
/*
*######################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize=$_PHPCMS[pagesize];
$referer=$referer ? $referer : $PHP_REFERER;
$action=$action ? $action : 'manage';

switch($action){

case 'delete':

	if(empty($commentid))
	{
		showmessage('非法参数！请返回！');
	}
	$commentids=is_array($commentid) ? implode(',',$commentid) : $commentid;
	$db->query("DELETE FROM ".TABLE_COMMENT." WHERE commentid IN ($commentids) and item='$item'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'pass':

	if(empty($commentid))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	if(!ereg('^[0-1]+$',$passed))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	$commentids=is_array($commentid) ? implode(',',$commentid) : $commentid;
	$db->query("UPDATE ".TABLE_COMMENT." SET passed=$passed WHERE commentid IN ($commentids) AND  item='$item'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
	break;

case 'manage':
	require_once PHPCMS_ROOT."/class/ip.php";

    $module = $_CHA['module'];
	$table = $tablepre.$module;
    $id = $module."id";

	$passed = isset($passed) ? $passed : "1";
	$referer = urlencode("?mod=".$mod."&file=comment&action=manage&passed=".$passed."&item=".$item."&itemid=".$itemid."&channelid=".$channelid."&page=".$page);
	$getip = new IpLocation;
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}
	
	$condition = " AND passed=$passed ";
	$condition .= $keywords ? " AND username LIKE '%$keywords%' OR content LIKE '%$keywords%' " : "";
	$condition .= $itemid ? " AND itemid='$itemid' " : "";
	$condition .= $ip ? " AND ip='$ip' " : "";
	$condition .=$item ? " AND item='$item' " : "";
	$condition .= $srchfrom ? " AND addtime>$timestamp-$srchfrom*86400 " : "";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_COMMENT." WHERE 1 $condition");
	$number=$r['num'];
	$url="?mod=".$mod."&file=comment&passed=".$passed."&keywords=".$keywords."&item=".$item."&itmid=".$itemid."&ip=".$ip."&srchfrom=".$srchfrom."&channelid=".$channelid."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);

	$result=$db->query("SELECT * FROM ".TABLE_COMMENT." WHERE 1 $condition ORDER BY commentid DESC LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$rs = $db->get_one("SELECT catid,addtime FROM $table WHERE $id=$r[itemid]");
		$r['adddate']=date("Y-m-d",$r['addtime']);
		$r['addtime']=date("Y-m-d H:i:s",$r['addtime']);
		$r['gip']=$getip->getlocation($r['ip']);
		$p->set_catid($rs[catid]);
		$r['url'] = $p->get_itemurl($r['itemid'],$rs['addtime']);
		$comments[]=$r;
	}
	include admintpl('comment_manage');
	break;
}
?>