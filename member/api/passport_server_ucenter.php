<?php
if($action == 'register')
{
	$uid = uc_call("uc_user_register", array($username, $password, $email));

	if($uid <= 0)
	{
		if($uid == -1)
		{
			showmessage('用户名不合法');
		}
		elseif($uid == -2)
		{
			showmessage('包含要允许注册的词语');
		}
		elseif($uid == -3)
		{
			showmessage('用户名已经存在');
		}
		elseif($uid == -4)
		{
			showmessage('Email 格式有误');
		}
		elseif($uid == -5)
		{
			showmessage('Email 不允许注册');
		}
		elseif($uid == -6)
		{
			showmessage('该 Email 已经被注册');
		}
		else
		{
			showmessage('未定义');
		}

	}
	$userid = '';
	$r = $member->get_by_touserid($uid);//modify by skyz
	if(!$r)
	{
		require_once MOD_ROOT.'api/member_api.class.php';
		$member_api = new member_api();
		$memberinfo['touserid'] = $uid;//modify by skyz
		$userid = $member_api->add($memberinfo);
	}
}
elseif ($action == 'login')
{
    $username = trim($username);
    $password = trim($password);
	$phpcmsUsername=$username;
	$phpcmsPassword=$password;
	list($uid, $username, $uc_password, $email) =  uc_call("uc_user_login", array($username, $password));
	/*增加用户自动导入功能*/
	if($uid==-1){
		$_userid = $member->get_userid($phpcmsUsername);
		$_userInfo=$member->get($_userid, '`userid`,`username`,`email`,`password`', 0);
		if($_userInfo['userid']>0){
			$md5_password = $member->password($phpcmsPassword);
			if($_userInfo['password'] != $md5_password)
			{
				if($r['password'] == substr($md5_password, 8, 16))
				{
					//兼容动易论坛
					$uid = uc_call("uc_user_register", array($_userInfo['username'], $phpcmsPassword, $_userInfo['email']));
					if($uid<=0){
						showmessage('用户不存在,或者被删除');
					}
				}
				else
				{
					showmessage('用户不存在,或者被删除');
					return FALSE;
				}
			}else{
				$uid = uc_call("uc_user_register", array($_userInfo['username'], $phpcmsPassword, $_userInfo['email']));
				if($uid<=0){
					showmessage('用户不存在,或者被删除');
				}
			}
		}
		list($uid, $username, $uc_password, $email) =  uc_call("uc_user_login", array($phpcmsUsername, $phpcmsPassword));
	}
	if( $uid == -1 )
	{
		showmessage('用户不存在,或者被删除');
	}
	if($uid == '-2')
	{
		showmessage('密码错误',$MODULE['member']['url'].'login.php');
	}
    $code = uc_call('uc_user_synlogin', array($uid));
	$phpcms_userid = $member->get_userid($username);
	if($phpcms_userid<=0 && $uid > 0)
	{
		require_once MOD_ROOT.'api/member_api.class.php';
		$member_api = new member_api();
		$arr_member['touserid'] = $uid;//modify by skyz
		$arr_member['registertime'] = TIME;
		$arr_member['lastlogintime'] = TIME;
		$arr_member['username'] = $username;
		$arr_member['password'] = $password;
		$arr_member['email'] = $email;
		$arr_member['modelid'] = 10;
		$member_api->add($arr_member);
	}else if($phpcms_userid>0 && $uid > 0){
		require_once MOD_ROOT.'api/member_api.class.php';
		$member_api = new member_api();
		$arr_member=array();
		$arr_member['touserid'] = $uid;//modify by skyz
		$member_api->set($phpcms_userid,$arr_member);
	}
}
elseif ($action == 'logout')
{
    $ucsynlogout = uc_call('uc_user_synlogout', array());
}
elseif ($action == 'editpwd')
{
	uc_call("uc_user_edit", array($username, $old_password, $new_password, $email));
	if($ucresult == -1)
	{
		showmessage('旧密码不正确');
	}
	elseif($ucresult == -4)
	{
		showmessage('Email 格式有误');
	}
	elseif($ucresult == -5)
	{
		showmessage('Email 不允许注册');
	}
	elseif($ucresult == -6)
	{
		showmessage('该 Email 已经被注册');
	}
}
elseif ($action == 'edit')
{
	uc_call("uc_user_edit", array($username, '', $password, $email, 1));
}
?>