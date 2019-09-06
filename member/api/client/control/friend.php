<?php

/*
	[UCenter] (C)2001-2008 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: friend.php 12126 2008-01-11 09:40:32Z heyond $
*/

!defined('IN_UC') && exit('Access Denied');

class friendcontrol extends base {

	function friendcontrol() {
		$this->base();
		$this->load('friend');
	}

	function ondelete($arr) {
		@extract($arr, EXTR_SKIP);//uid friendids
		$id = $_ENV['friend']->delete($uid, $friendids);
		return $id;
	}

	function onadd($arr) {
		@extract($arr, EXTR_SKIP);//uid friendid comment
		$id = $_ENV['friend']->add($uid, $friendid, $comment);
		return $id;
	}

	function ontotalnum($arr) {
		@extract($arr, EXTR_SKIP);//uid direction
		$totalnum = $_ENV['friend']->get_totalnum_by_uid($uid, $direction);
		return $totalnum;
	}

	function onls($arr) {
		@extract($arr, EXTR_SKIP);//uid page pagesize totalnum direction
		$totalnum = $totalnum ? $totalnum : $_ENV['friend']->get_totalnum_by_uid($uid);
		$data = $_ENV['friend']->get_list($uid, $page, $pagesize, $totalnum, $direction);
		return $data;
	}
}

?>