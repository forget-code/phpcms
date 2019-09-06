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
	$r = $member->get($uid);
	if(!$r)
	{
		require_once MOD_ROOT.'api/member_api.class.php';
		$member_api = new member_api();
		$memberinfo['userid'] = $uid;
		$userid = $member_api->add($memberinfo);
	}
}
elseif ($action == 'login')
{
    $username = trim($username);
    $password = trim($password);
	list($uid, $username, $uc_password, $email) =  uc_call("uc_user_login", array($username, $password));
	if( $uid == -1 )
	{
		showmessage('用户不存在,或者被删除');
	}
	if($uid == '-2')
	{
		showmessage('密码错误');
	}
    $code = uc_call('uc_user_synlogin', array($uid));
	$result = $member->get_userid($username);
	if(!$result && $uid != 1 && $uid > 0)
	{
		require_once MOD_ROOT.'api/member_api.class.php';
		$member_api = new member_api();
		$arr_member['userid'] = $uid;
		$arr_member['registertime'] = TIME;
		$arr_member['lastlogintime'] = TIME;
		$arr_member['username'] = $username;
		$arr_member['password'] = $password;
        $arr_member['groupid'] = 4;
		$arr_member['email'] = $email;
		$arr_member['modelid'] = 10;
		$member_api->add($arr_member);
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
	uc_call("uc_user_edit", array($username, '', password, $email, 1));
}
?>