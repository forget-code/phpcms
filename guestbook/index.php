<?php
require_once './include/common.inc.php';
require_once './include/guestbook.class.php';
$g = new guestbook;
if(!$M['show']) showmessage($LANG['message_disable'],'goback');
$pagesize = $M['pagesize'] ?  $M['pagesize'] : 10 ;
$page = $page ? intval($page) : 1 ;
$gid = isset($gid) ? intval($gid) : 0;
$srchtype = isset($srchtype) ? intval($srchtype) : 0 ;
$keyword = isset($keyword) ? $keyword : '' ;
$condition = " and ((passed=1) or (username = '".$_username."' and passed=1 )) ";
if(!empty($keyword))
{
	$keyword=str_replace(' ','%',$keyword);
	$keyword=str_replace('*','%',$keyword);
	$keyword = safe_replace($keyword);
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
$gbooks = array();
if($gid) $condition .= " and gid=$gid";
$data = $g->listinfo($condition,$page,$pagesize);
$pages = $g->pages;
include template('guestbook','index');
?>