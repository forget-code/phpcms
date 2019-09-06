<?php	
	$table_member_columns = array('username', 'password', 'email', 'areaid', 'groupid', 'amount', 'point');
	chdir('../');
	require 'include/common.inc.php';
	if(!$PHPCMS['enableserverpassport'])
	{
		exit('Passport disabled');
	}
	elseif($verify != md5($action.$userdb.$forward.$PHPCMS['passport_serverkey']))
	{
		exit('Illegal request');
	}
	$db_hash = $PHPCMS['passport_serverkey'];
	$_db_hash = $db_hash;
	parse_str(StrCode($userdb,'DECODE'), $arr_member);
	$arr_member['cookietime'] = $arr_member['cktime'] ? $arr_member['cktime'] - TIME : 0;
	if ($action == 'login')
	{
		$memberfields = $remoteinfo = array();
		foreach ($arr_member as $key => $val)
		{
			$memberfields[$key] = addslashes($val);
			if (in_array($key, array('cookietime', 'time')))
			{
				$remoteinfo[$key] = $val;
			}
			elseif ($key == 'isadmin' && $val)
			{
				$memberfields['groupid'] = 1;
			}
		}
		$memberfields['username'] = preg_replace("/(c:\\con\\con$|[%,\*\"\s\t\<\>\&])/i", "", $memberfields['username']);
		if(strlen($memberfields['username']) > 20) $memberfields['username'] = substr($memberfields['username'], 0, 20);
		if(empty($remoteinfo['time']) || empty($memberfields['username']) || empty($memberfields['password']) || empty($memberfields['email']))
		{
			exit('Lack of required parameters');
		}
		elseif($PHPCMS['passport_expire'] && TIME - $remoteinfo['time'] > $PHPCMS['passport_expire'])
		{
			exit('Request expired');
		}
		$userid = $member->get_userid($memberfields['username']);
		if($userid)
		{
			if(!$memberfields['regip']) $memberfields['regip'] = IP;
			if(!$memberfields['regtime']) $memberfields['regtime'] = TIME;
			if(!$memberfields['regip']) $memberfields['regip'] = IP;
			if(!$memberfields['regtime']) $memberfields['regtime'] = TIME;
			$memberinfo = $member->get($userid, 'm.username, m.password, i.logintimes', 1);
			$password = $memberinfo['answer'];
			$info = '';
			foreach ($memberfields as $k=>$v)
			{
				$info[$k] = $v;
			}
			$info['userid'] = $userid;
			$member->edit($info);
		}
		else 
		{
			require_once 'member_api.class.php';
			$member_api = new member_api();
			$userid = $member_api->add($memberfields);
		}
		$forward = empty($forward) ? $PHPCMS['passport_serverurl'] : $forward;
		$cookietime = $arr_member['cookietime'] ? TIME + $arr_member['cookietime'] : 0;
		$phpcms_auth_key = md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
		$phpcms_auth = phpcms_auth($userid."\t".$info['password'], 'ENCODE', $phpcms_auth_key);
		set_cookie('auth', $phpcms_auth, $cookietime);
		set_cookie('cookietime', $_cookietime, $cookietime);
	}
	elseif ($action == 'logout' || $action == 'quit')
	{
		set_cookie('auth', '');
		set_cookie('cookietime', '');
		session_start();
		unset($_SESSION['is_admin']);
		$forward = empty($forward) ? $PHPCMS['passport_serverurl'] : $forward;	
	}
	elseif ($action == 'delete')
	{
    	$userid = $cls_member->get_userid($arr_member['username']);
		if($userid)
		{
			$member->delete($userid);
		}
		if(!$forward) $forward = HTTP_REFERER ? HTTP_REFERER : $PHPCMS['passport_serverurl'];
		header('location:'.$forward);
	}
	header('location:'.$forward);
	
	function StrCode($string,$action='ENCODE')
	{
		$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$GLOBALS['db_hash']),8,18);
		$string	= $action == 'ENCODE' ? $string : base64_decode($string);
		$len	= strlen($key);
		$code	= '';
		for($i=0; $i<strlen($string); $i++)
		{
			$k		= $i % $len;
			$code  .= $string[$i] ^ $key[$k];
		}
		$code = $action == 'DECODE' ? $code : base64_encode($code);
		return $code;
	}
?>