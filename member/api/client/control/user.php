<?php

/*
	[UCenter] (C)2001-2008 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: user.php 12126 2008-01-11 09:40:32Z heyond $
*/

!defined('IN_UC') && exit('Access Denied');

class usercontrol extends base {

	function usercontrol() {
		$this->base();
		$this->load('user');
	}

	function onregister($arr) {
		@extract($arr, EXTR_SKIP);//username, password, email
		if(($status = $this->_check_username($username)) < 0) {
			return $status;
		}
		if(($status = $this->_check_email($email)) < 0) {
			return $status;
		}
		$uid = $_ENV['user']->add_user($username, $password, $email);
		return $uid;
	}

	function onedit($arr) {
		@extract($arr, EXTR_SKIP);//username, oldpw, newpw, email, ignoreoldpw
		if(!$ignoreoldpw && $email && ($status = $this->_check_email($email)) < 0) {
			return $status;
		}
		$status = $_ENV['user']->edit_user($username, $oldpw, $newpw, $email, $ignoreoldpw);

		if($newpw && $status > 0) {
			$this->load('note');
			$_ENV['note']->add('updatepw', 'username='.urlencode($username).'&password='.urlencode($newpw));
		}
		return $status;
	}

	function onlogin($arr) {
		@extract($arr, EXTR_SKIP);//username, password, isuid
		if($isuid) {
			$user = $_ENV['user']->get_user_by_uid($username);
		} else {
			$user = $_ENV['user']->get_user_by_username($username);
		}
		if(empty($user)) {
			$status = -1;
		} elseif($user['password'] != md5(md5($password).$user['salt'])) {
			$status = -2;
		} else {
			$status = $user['uid'];
		}
		$merge = $status != -1 && !$isuid && $_ENV['user']->check_mergeuser($username) ? 1 : 0;
		return array($status, $user['username'], $password, $user['email'], $merge);
	}

	function oncheck_email($arr) {
		@extract($arr, EXTR_SKIP);//email
		return $this->_check_email($email);
	}

	function oncheck_username($arr) {
		@extract($arr, EXTR_SKIP);//username
		if(($status = $this->_check_username($username)) < 0) {
			return $status;
		} else {
			return 1;
		}
	}

	function onget_user($arr) {
		@extract($arr, EXTR_SKIP);//username
		if(!$isuid) {
			$status = $_ENV['user']->get_user_by_username($username);
		} else {
			$status = $_ENV['user']->get_user_by_uid($username);
		}
		if($status) {
			return array($status['uid'],$status['username'],$status['email']);
		} else {
			return 0;
		}
	}

	function ondelete($arr) {
		@extract($arr, EXTR_SKIP);//uid
		return $_ENV['user']->delete_user($uid);
	}

	function ongetprotected() {
		$protectedmembers = $this->db->fetch_all("SELECT username FROM ".UC_DBTABLEPRE."protectedmembers GROUP BY username");
		return $protectedmembers;
	}

	function onaddprotected($arr) {
		@extract($arr, EXTR_SKIP);
		$appid = UC_APPID;
		$usernames = (array)$username;
		foreach($usernames as $username) {
			$user = $_ENV['user']->get_user_by_username($username);
			$uid = $user['uid'];
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."protectedmembers SET uid='$uid', username='$username', appid='$appid', dateline='{$this->time}', admin='$admin'", 'SILENT');
		}
		return $this->db->errno() ? -1 : 1;
	}

	function ondeleteprotected($arr) {
		@extract($arr, EXTR_SKIP);//uid
		$appid = UC_APPID;
		$usernames = (array)$username;
		foreach($usernames as $username) {
			$this->db->query("DELETE FROM ".UC_DBTABLEPRE."protectedmembers WHERE username='$username' AND appid='$appid'");
		}
		return $this->db->errno() ? -1 : 1;
	}

	function _check_username($username) {
		$username = addslashes(trim(stripslashes($username)));
		if(!$_ENV['user']->check_username($username)) {
			return -1;
		} elseif($username != $_ENV['user']->check_usernamecensor($username)) {
			return -2;
		} elseif($_ENV['user']->check_usernameexists($username)) {
			return -3;
		}
		return 1;
	}

	function _check_email($email) {
		if(!$this->settings) {
			$this->settings = $this->cache('settings');
			$this->settings = $this->settings['settings'];
		}
		if(!$_ENV['user']->check_emailformat($email)) {
			return -4;
		} elseif(!$_ENV['user']->check_emailaccess($email)) {
			return -5;
		} elseif(!$this->settings['doublee'] && $_ENV['user']->check_emailexists($email)) {
			return -6;
		} else {
			return 1;
		}
	}

	function onmerge($arr) {
		@extract($arr, EXTR_SKIP);//oldusername, newusername, uid, password, email
		if(($status = $this->_check_username($newusername)) < 0) {
			return $status;
		}
		$uid = $_ENV['user']->add_user($newusername, $password, $email, $uid);
		$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET msgfrom='$newusername' WHERE msgfromid='$uid' AND msgfrom='$oldusername'");
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."mergemembers WHERE appid='".UC_APPID."' AND username='$oldusername'");
		return $uid;
	}

}

?>