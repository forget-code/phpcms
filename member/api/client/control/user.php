<?php

/*
	[UCenter] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: user.php 753 2008-11-14 06:48:25Z cnteacher $
*/

!defined('IN_UC') && exit('Access Denied');

define('UC_USER_CHECK_USERNAME_FAILED', -1);
define('UC_USER_USERNAME_BADWORD', -2);
define('UC_USER_USERNAME_EXISTS', -3);
define('UC_USER_EMAIL_FORMAT_ILLEGAL', -4);
define('UC_USER_EMAIL_ACCESS_ILLEGAL', -5);
define('UC_USER_EMAIL_EXISTS', -6);

class usercontrol extends base {


	function __construct() {
		$this->usercontrol();
	}

	function usercontrol() {
		parent::__construct();
		$this->load('user');
		//note client 仅在需要时初始化 $this->app
		$this->app = $this->cache['apps'][UC_APPID];
	}

	//note public 外部接口
	// -1 未开启
	function onsynlogin() {
		$this->init_input();
		$uid = $this->input('uid');
		if($this->app['synlogin']) {
			if($this->user = $_ENV['user']->get_user_by_uid($uid)) {
				$synstr = '';
				foreach($this->cache['apps'] as $appid => $app) {
					if($app['synlogin'] && $app['appid'] != $this->app['appid']) {
						$synstr .= '<script type="text/javascript" src="'.$app['url'].'/api/uc.php?time='.$this->time.'&code='.urlencode($this->authcode('action=synlogin&username='.$this->user['username'].'&uid='.$this->user['uid'].'&password='.$this->user['password']."&time=".$this->time, 'ENCODE', $app['authkey'])).'"></script>';
					}
				}
				return $synstr;
			}
		}
		return '';
	}

	//note public 外部接口
	function onsynlogout() {
		$this->init_input();
		if($this->app['synlogin']) {
			$synstr = '';
			foreach($this->cache['apps'] as $appid => $app) {
				if($app['synlogin'] && $app['appid'] != $this->app['appid']) {
					$synstr .= '<script type="text/javascript" src="'.$app['url'].'/api/uc.php?time='.$this->time.'&code='.urlencode($this->authcode('action=synlogout&time='.$this->time, 'ENCODE', $app['authkey'])).'"></script>';
				}
			}
			return $synstr;
		}
		return '';
	}

	//note public 外部接口 注册校验接口
	function onregister() {
		$this->init_input();
		$username = $this->input('username');
		$password =  $this->input('password');
		$email = $this->input('email');
		$questionid = $this->input('questionid');
		$answer = $this->input('answer');

		if(($status = $this->_check_username($username)) < 0) {
			return $status;
		}
		if(($status = $this->_check_email($email)) < 0) {
			return $status;
		}
		$uid = $_ENV['user']->add_user($username, $password, $email, 0, $questionid, $answer);
		return $uid;
	}

	//note public 外部接口 编辑帐户信息
	function onedit() {
		$this->init_input();
		$username = $this->input('username');
		$oldpw = $this->input('oldpw');
		$newpw = $this->input('newpw');
		$email = $this->input('email');
		$ignoreoldpw = $this->input('ignoreoldpw');
		$questionid = $this->input('questionid');
		$answer = $this->input('answer');

		if(!$ignoreoldpw && $email && ($status = $this->_check_email($email, $username)) < 0) {
			return $status;
		}
		$status = $_ENV['user']->edit_user($username, $oldpw, $newpw, $email, $ignoreoldpw, $questionid, $answer);

		if($newpw && $status > 0) {
			$this->load('note');
			$_ENV['note']->add('updatepw', 'username='.urlencode($username).'&password=');
			$_ENV['note']->send();
		}
		return $status;
	}

	//note public 外部接口 登陆接口
	function onlogin() {
		$this->init_input();
		$isuid = $this->input('isuid');
		$username = $this->input('username');
		$password = $this->input('password');
		$checkques = $this->input('checkques');
		$questionid = $this->input('questionid');
		$answer = $this->input('answer');
		if($isuid) {
			$user = $_ENV['user']->get_user_by_uid($username);
		} else {
			$user = $_ENV['user']->get_user_by_username($username);
		}

		$passwordmd5 = preg_match('/^\w{32}$/', $password) ? $password : md5($password);
		//note 用户名不存在
		if(empty($user)) {
			$status = -1;
		} elseif($user['password'] != md5($passwordmd5.$user['salt'])) {
			$status = -2;
		} elseif($checkques && $user['secques'] != '' && $user['secques'] != $_ENV['user']->quescrypt($questionid, $answer)) {
			$status = -3;
		} else {
			$status = $user['uid'];
		}
		$merge = $status != -1 && !$isuid && $_ENV['user']->check_mergeuser($username) ? 1 : 0;
		return array($status, $user['username'], $password, $user['email'], $merge);
	}

	//note public 外部接口 ajax 校验 EMAIL
	function oncheck_email() {
		$this->init_input();
		$email = $this->input('email');
		return $this->_check_email($email);
	}

	//note public 外部接口 ajax 校验用户名
	function oncheck_username() {
		$this->init_input();
		$username = $this->input('username');
		if(($status = $this->_check_username($username)) < 0) {
			return $status;
		} else {
			return 1;
		}
	}

	//note public 外部接口
	function onget_user() {
		$this->init_input();
		$username = $this->input('username');
		if(!$this->input('isuid')) {
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


	//note public 得到保护的用户列表
	function ongetprotected() {
		$protectedmembers = $this->db->fetch_all("SELECT uid,username FROM ".UC_DBTABLEPRE."protectedmembers GROUP BY username");
		return $protectedmembers;
	}

	//note 用户中心, 非外部接口.
	function ondelete() {
		$this->init_input();
		$uid = $this->input('uid');
		return $_ENV['user']->delete_user($uid);
	}

	function onaddprotected() {
		$this->init_input();
		$username = $this->input('username');
		$admin = $this->input('admin');
		$appid = $this->app['appid'];
		$usernames = (array)$username;
		foreach($usernames as $username) {
			$user = $_ENV['user']->get_user_by_username($username);
			$uid = $user['uid'];
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."protectedmembers SET uid='$uid', username='$username', appid='$appid', dateline='{$this->time}', admin='$admin'", 'SILENT');
		}
		return $this->db->errno() ? -1 : 1;
	}

	function ondeleteprotected() {
		$this->init_input();
		$username = $this->input('username');
		$appid = $this->app['appid'];
		$usernames = (array)$username;
		foreach($usernames as $username) {
			$this->db->query("DELETE FROM ".UC_DBTABLEPRE."protectedmembers WHERE username='$username' AND appid='$appid'");
		}
		return $this->db->errno() ? -1 : 1;
	}

	function onmerge() {
		$this->init_input();
		$oldusername = $this->input('oldusername');
		$newusername = $this->input('newusername');
		$uid = $this->input('uid');
		$password = $this->input('password');
		$email = $this->input('email');
		if(($status = $this->_check_username($newusername)) < 0) {
			return $status;
		}
		$uid = $_ENV['user']->add_user($newusername, $password, $email, $uid);
		$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET msgfrom='$newusername' WHERE msgfromid='$uid' AND msgfrom='$oldusername'");
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."mergemembers WHERE appid='".$this->app['appid']."' AND username='$oldusername'");
		return $uid;
	}

	function onmerge_remove() {
		$this->init_input();
		$username = $this->input('username');
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."mergemembers WHERE appid='".$this->app['appid']."' AND username='$username'");
		return NULL;
	}

	//note private 校验用户名
	function _check_username($username) {
		$username = addslashes(trim(stripslashes($username)));
		if(!$_ENV['user']->check_username($username)) {
			return UC_USER_CHECK_USERNAME_FAILED;
		} elseif(!$_ENV['user']->check_usernamecensor($username)) {
			return UC_USER_USERNAME_BADWORD;
		} elseif($_ENV['user']->check_usernameexists($username)) {
			return UC_USER_USERNAME_EXISTS;
		}
		return 1;
	}

	//note private 校验email
	function _check_email($email, $username = '') {
		if(empty($this->settings)) {
			$this->settings = $this->cache('settings');
		}
		if(!$_ENV['user']->check_emailformat($email)) {
			return UC_USER_EMAIL_FORMAT_ILLEGAL;
		} elseif(!$_ENV['user']->check_emailaccess($email)) {
			return UC_USER_EMAIL_ACCESS_ILLEGAL;
		} elseif(!$this->settings['doublee'] && $_ENV['user']->check_emailexists($email, $username)) {
			return UC_USER_EMAIL_EXISTS;
		} else {
			return 1;
		}
	}

	function ongetcredit($arr) {
		$this->init_input();
		$appid = $this->input('appid');
		$uid = $this->input('uid');
		$credit = $this->input('credit');
		$this->load('note');
		$this->load('misc');
		$app = $this->cache['apps'][$appid];
		$url = $_ENV['note']->get_url_code('getcredit', "uid=$uid&credit=$credit", $appid);
		return $_ENV['misc']->dfopen($url, 0, '', '', 1, $app['ip'], UC_NOTE_TIMEOUT);
	}


	/**
	 * -1 身份不合法
	 * -2 上传的数据流不合法
	 * -3 没有上传头象
	 */
	//note public 外部接口 flash 上传头像
	function onuploadavatar() {
	}

	//note public 外部接口 flash 方式裁剪头像 COOKIE 判断身份
	function onrectavatar() {
	}
	function flashdata_decode($s) {
	}
}

?>