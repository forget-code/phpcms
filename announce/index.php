<?php
require './include/common.inc.php';
require_once MOD_ROOT.'/include/announce.class.php';
$a = new announce;
$pagesize = $M['pagesize'] ?  $M['pagesize'] : 15;
$page = $page ? $page : 1 ;
$announceid = intval($announceid) ? intval($announceid) : '';
if($announceid)
{
	$annou = $a->getone($announceid);
	if($annou)
	{
		$a->update($announceid);
		@extract($annou);
	}
}
else
{
	$annou = $a->show("WHERE passed=1");
	if($annou)
	{
		@extract($annou);
		$a->update($announceid);
	}
}
$announces = $a->listinfo($page,$pagesize,"WHERE passed=1");
include template($mod, 'index');
?>