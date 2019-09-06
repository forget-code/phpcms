<?php 
error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$table_member_columns = array('username', 'password', 'question', 'answer', 'email', 'showemail', 'groupid', 'regip', 'regtime');
$table_member_info_columns = array('truename', 'gender', 'birthday', 'province', 'city', 'area', 'telephone', 'mobile', 'address', 'postid', 'homepage', 'qq', 'msn', 'icq', 'skype', 'alipay', 'paypal');

chdir('../../');
require './include/common.inc.php';

if(!$PHPCMS['enableserverpassport'])
{
	exit('Passport disabled');
}
elseif($verify != md5($action.$auth.$forward.$PHPCMS['passport_serverkey']))
{
	exit('Illegal request');
}

if($action == 'login')
{
	$memberfields = $memberinfofields = $remoteinfo = array();
	parse_str(passport_decrypt($auth, $PHPCMS['passport_serverkey']), $member);

	$member['gender'] = $member['gender'] - 1;
	$member['regtime'] = $member['regdate'];

	foreach($member as $key => $val)
	{
		if(in_array($key, $table_member_columns))
		{
			$memberfields[$key] = addslashes($val);
		}
		elseif(in_array($key, $table_member_info_columns))
		{
			$memberinfofields[$key] = addslashes($val);
		}
		elseif(in_array($key, array('cookietime', 'time')))
		{
			$remoteinfo[$key] = $val;
		}
		elseif($key == 'isadmin' && $val)
		{
			$memberfields['groupid'] = 1;
		}
	}
	$memberfields['username'] = preg_replace("/(c:\\con\\con$|[%,\*\"\s\t\<\>\&])/i", "", $memberfields['username']);
	if(strlen($memberfields['username']) > 30) $memberfields['username'] = substr($memberfields['username'], 0, 30);

	if(empty($remoteinfo['time']) || empty($memberfields['username']) || empty($memberfields['password']) || empty($memberfields['email']))
	{
		exit('Lack of required parameters');
	}
	elseif($PHPCMS['passport_expire'] && $PHP_TIME - $remoteinfo['time'] > $PHPCMS['passport_expire'])
	{
		exit('Request expired');
	}

	if(!$memberfields['regip']) $memberfields['regip'] = $PHP_IP;
	if(!$memberfields['regtime']) $memberfields['regtime'] = $PHP_TIME;
	if(!$memberfields['lastloginip']) $memberfields['lastloginip'] = $PHP_IP;
	if(!$memberfields['lastlogintime']) $memberfields['lastlogintime'] = $PHP_TIME;
	if(!$memberfields['answer']) $memberfields['answer'] = '';

	$m = $db->get_one("SELECT userid,password,answer FROM ".TABLE_MEMBER." WHERE username='$memberfields[username]' LIMIT 1");
	if($m)
	{
		$userid = $m['userid'];
		$password = $m['password'];
		$answer = $m['answer'];
		$info = '';
		foreach($memberfields as $k=>$v)
		{
			$info .= $k."='".$v."',";
		}
        $db->query("UPDATE ".TABLE_MEMBER." SET $info logintimes=logintimes+1 WHERE userid=$userid");
		$info = '';
		foreach($memberinfofields as $k=>$v)
		{
			$info .= ','.$k."='".$v."'";
		}
		if($info)
		{
			$info = substr($info, 1);
			$db->query("UPDATE ".TABLE_MEMBER_INFO." SET $info WHERE userid=$userid");
		}
	}
	else
	{
	    if(!$memberfields['groupid']) $memberfields['groupid'] = 6;
		$fields = implode(',', array_keys($memberfields));
		$values = "'".implode("','", array_values($memberfields))."'";
        $db->query("INSERT INTO ".TABLE_MEMBER."($fields,logintimes) VALUES($values,'1')");
		$userid = $db->insert_id();
		if($memberinfofields)
		{
			$fields = implode(',', array_keys($memberinfofields));
			$values = "'".implode("','", array_values($memberinfofields))."'";
			$db->query("INSERT INTO ".TABLE_MEMBER_INFO."(userid,$fields) VALUES('$userid',$values)");
		}
		else
		{
			$db->query("INSERT INTO ".TABLE_MEMBER_INFO."(userid) VALUES('$userid')");
		}
		if($memberfields['groupid'] == 1)
		{
			$db->query("INSERT INTO ".TABLE_ADMIN."(userid,username,grade) VALUES('$userid','$memberfields[username]','0')");
		}
		$password = $memberfields['password'];
		$answer = $memberfields['answer'];
	}
    $cookietime = $remoteinfo['cookietime'] ? $PHP_TIME + $remoteinfo['cookietime'] : 0;
	$phpcms_auth_key = md5($PHPCMS['authkey'].$_SERVER['HTTP_USER_AGENT']);
	$phpcms_auth = phpcms_auth($userid."\t".$password."\t".$answer, 'ENCODE', $phpcms_auth_key);
	mkcookie('auth', $phpcms_auth, $cookietime);

    $forward = empty($forward) ? $PHPCMS['passport_serverurl'] : $forward;
	if($PHPCMS['enablepassport'])
	{
		$action = 'login';
		$info = array_merge($memberfields, $memberinfofields);
		extract($info);
		require PHPCMS_ROOT.'/member/passport/'.$PHPCMS['passport_file'].'.php';
		header('location:'.$url);
		exit;
	}
	header('Location:'.$forward);
	exit;
}
elseif($action == 'logout')
{
	mkcookie('auth', '');
	unset($_SESSION['admin_grade'], $_SESSION['admin_modules'], $_SESSION['admin_channelids'], $_SESSION['admin_purviewids'], $_SESSION['admin_catids'], $_SESSION['admin_specialids']);
    $forward = empty($forward) ? $PHPCMS['passport_serverurl'] : $forward;
	if($PHPCMS['enablepassport'])
	{
		$forward = linkurl($forward, 1);
		$action = 'logout';
		require PHPCMS_ROOT.'/member/passport/'.$PHPCMS['passport_file'].'.php';
		header('location:'.$url);
		exit;
	}
	header('location:'.$forward);
}
elseif($action == 'delete')
{
	parse_str(passport_decrypt($auth, $PHPCMS['passport_serverkey']), $member);
	$member['username'] = preg_replace("/(c:\\con\\con$|[%,\*\"\s\t\<\>\&])/i", "", $memberfields['username']);
	if(strlen($member['username']) > 30) $member['username'] = substr($member['username'], 0, 30);
    if(empty($member['username'])) exit('Lack of required parameters');
   
	$username = $member['username'];
	$m = $db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$username' LIMIT 1");
	if($m)
	{
		$userid = $m['userid'];
		$db->query("DELETE FROM ".TABLE_MEMBER." WHERE userid=$userid");
		$db->query("DELETE FROM ".TABLE_MEMBER_INFO." WHERE userid=$userid");
	}
    if(!$forward) $forward = $PHP_REFERER ? $PHP_REFERER : $PHPCMS['passport_serverurl'];
	header('location:'.$forward);
}

function passport_encrypt($txt, $key) 
{
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++)
	{
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}

function passport_decrypt($txt, $key)
{
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++)
	{
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

function passport_key($txt, $encrypt_key)
{
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++)
	{
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}
?>