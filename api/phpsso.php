<?php
/*
 * 客户端被动接收phpsso服务端通知
 * 服务端通知内容:同步登陆、退出，同步积分设置、对换比率，同步添加、删除用户、修改用户密码，测试通信状态
 * 
 */
	defined('IN_PHPCMS') or exit('No permission resources.'); 

	$db = pc_base::load_model('member_model');
	
	$system = pc_base::load_config('system');
	define('APPID', $system['phpsso_appid']);
	$ps_api_url = $system['phpsso_api_url'];	//接口地址
	$ps_auth_key = $system['phpsso_auth_key'];	//加密密钥
	$ps_version = $system['phpsso_version'];
	
	pc_base::load_app_class('client', 'member', 0);
	$client = new client($ps_api_url, $ps_auth_key);
	$code = $_REQUEST['code'];
	
	parse_str($client->sys_auth($code, 'DECODE'), $arr);
	if(isset($arr['action'])) {
		$action = $arr['action'];
	} else {
		exit('0');
	}

	/**
	 * 测试通信状态
	 */
	if ($action == 'check_status') exit('1');
	
	/**
	 * 添加用户
	 */
	if ($action == 'member_add') {
		$userinfo = array();
		$userinfo['phpssouid'] = isset($arr['uid']) ? $arr['uid'] : exit('0');
		$userinfo['encrypt'] = isset($arr['random']) ? $arr['random'] : exit('0');
		$userinfo['username'] = isset($arr['username']) ? $arr['username'] : exit('0');
		$userinfo['password'] = isset($arr['password']) ? $arr['password'] : exit('0');
		$userinfo['email'] = isset($arr['email']) ? $arr['email'] : '';
		$userinfo['regip'] = isset($arr['regip']) ? $arr['regip'] : '';
		$userinfo['regdate'] = $userinfo['lastdate'] = SYS_TIME;
		$userinfo['modelid'] = 10;
		$userinfo['groupid'] = 6;

		$userid = $db->insert($userinfo, 1);
		if($userid) {
			exit('1');
		} else {
			exit('0');
		}
	}
	
	/**
	 * 删除用户
	 */
	if ($action == 'member_delete') {
		$uidarr = $arr['uids'];
		$where = to_sqls($uidarr, '', 'phpssouid');
		
		$status = $db->delete($where);
		if($status) {
			exit('1');
		} else {
			exit('0');
		}
		
	}
	
	/**
	 * 编辑用户
	 */
	if ($action == 'member_edit') {
		if(!isset($arr['uid'])) exit('0');
		$userinfo = array();
		if(isset($arr['password'])) {
			$userinfo['password'] = $arr['password'];
			$userinfo['encrypt'] = $arr['random'];
		}
		if(isset($arr['email']) && !empty($arr['email'])) {
			$userinfo['email'] = $arr['email'];
		}
		if(empty($userinfo)) exit('1');
		$status = $db->update($userinfo, array('phpssouid'=> $arr['uid']));
		if($status) {
			exit('1');
		} else {
			exit('0');
		}
	}
	
	/**
	 * 应用积分列表
	 */
	if ($action == 'credit_list') {
		$credit_list = pc_base::load_config('credit');
		echo $client->array2string($credit_list);
		exit;
	}
	
	/**
	 * 更新积分兑换规则
	 */
	if ($action == 'credit_update') {
		setcache('creditchange', $arr, 'member');
		exit('1');
	}
	
	/**
	 * 同步登陆
	 */
	if ($action == 'synlogin') {
		
		if(!isset($arr['uid'])) exit('0');
					
		$phpssouid = $arr['uid'];
		$userinfo = $db->get_one(array('phpssouid'=>$phpssouid));
				
		if (!$userinfo) {
			//插入会员
			exit;
			$ps_userinfo = $client->ps_get_member_info($userid);
			$ps_userinfo = unserialize($ps_userinfo);

			if ($ps_userinfo['uid'] > 0) {
				require_once MOD_ROOT.'api/member_api.class.php';
				$member_api = new member_api();
				$arr_member['touserid'] = $ps_userinfo['uid'];
				$arr_member['registertime'] = TIME;
				$arr_member['lastlogintime'] = TIME;
				$arr_member['username'] = $ps_userinfo['username'];
				$arr_member['password'] = md5(PASSWORD_KEY.$password) ;
				$arr_member['email'] = $ps_userinfo['email'];
				$arr_member['modelid'] = 10;
				$member_api->add($arr_member);
				$userid = $member->get_userid($arr['username']);
				$userinfo = $member->get($userid);
			}

			$username = $ps_userinfo['username'];
		} else {
			$username = $userinfo['username'];
		}
		//执行本系统登陆操作
		$userid = $userinfo['userid'];
		$groupid = $userinfo['groupid'];
		$username = $userinfo['username'];
		$password = $userinfo['password'];
		$nickname = $userinfo['nickname'];
		$db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME), array('userid'=>$userid));
		pc_base::load_sys_class('param', '', 0);
		
		if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
		$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
		$cookietime = $_cookietime ? TIME + $_cookietime : 0;
		
		$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$_SERVER['HTTP_USER_AGENT']);
		$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');	
		param::set_cookie('auth', $phpcms_auth, $cookietime);
		param::set_cookie('_userid', $userid, $cookietime);
		param::set_cookie('_username', $username, $cookietime);
		param::set_cookie('_nickname', $nickname, $cookietime);
		param::set_cookie('_groupid', $groupid, $cookietime);
		param::set_cookie('cookietime', $_cookietime, $cookietime);
		exit('1');
	}
	
	/**
	 * 同步退出
	 */
	if ($action == 'synlogout') {
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		pc_base::load_sys_class('param', '', 0);
		param::set_cookie('auth', '');
		param::set_cookie('_userid', '');
		param::set_cookie('_username', '');
		param::set_cookie('_nickname', '');
		param::set_cookie('_groupid', '');
		param::set_cookie('cookietime', '');
		exit('1');
		//执行本系统退出操作
	}
	
	
	
	
	
	
?>