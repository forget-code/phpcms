<?php
defined('IN_YP') or exit('Access Denied');

if(!isset($action)) $action = 'manage';
include MOD_ROOT.'include/collect.class.php';
$c = new collect();
$c->set_userid($userid);
switch($action)
{
	case 'manage':
		
		if(isset($job))
		{
			$where = "WHERE userid='$_userid'";
		}
		else
		{
			$where = "WHERE vid='$_userid'";
		}
		$infos = $c->listinfo($where, '`cid` DESC', $page, 30, 1);
		$pages = $c->pages;
	break;

	case 'delete':
			$c->delete($cid);
			showmessage('操作成功',$forward);
		break;

}
include template('yp', 'center_collect');
?>