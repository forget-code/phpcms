<?php
require './include/common.inc.php';

if(!$forward) $forward = HTTP_REFERER;
if(!isset($action)) $action = '';
if($_userid) showmessage($LANG['you_have_logined'], SITE_URL);

$check = new times();
$check->set('checkcode', 3600, 1);

switch($action)
{
 	case 'ajax':

		$username = iconv('utf-8', CHARSET, $username);
		$password = iconv('utf-8', CHARSET, $password);

		$info = $member->login($username, $password, $cookietime);
		if(!$info)
		{
            $check->add();
			echo '0';
			exit;
		}
		else
		{
			echo 1;
			exit;
		}
		break;

    default:

		if($PHPCMS['enableserverpassport'])
		{
			$loginurl = $PHPCMS['passport_serverurl'].$PHPCMS['passport_loginurl'];
			if(QUERY_STRING) $loginurl .= strpos($loginurl, '?') ? '&'.QUERY_STRING : '?'.QUERY_STRING;
			elseif($username && $password && $dosubmit) $loginurl .= "?username=$username&password=$password&cookietime=$cookietime&dosubmit=1";
			header('location:'.$loginurl);
			exit;
		}

		if($dosubmit)
		{
			if($check->check()) checkcode($checkcodestr, 1, HTTP_REFERER);
			if($PHPCMS['uc'])
			{
				$action = 'login';
				require MOD_ROOT.'api/passport_server_ucenter.php';
			}
		    $info = $member->login($username, $password, $cookietime);
		    if(!$info)
			{
				$check->add();
				showmessage($member->msg(), HTTP_REFERER);
			}
			else
			{
				$check->clear();
				$forward = isset($forward) ? url($forward, 1) : SITE_URL;
				if($PHPCMS['enablepassport'])
	            {
			        $action = 'login';
					if($PHPCMS['passport_charset'] && $PHPCMS['passport_charset'] != CHARSET)
					{
						$info = iconv(CHARSET, $PHPCMS['passport_charset'], $info);
					}
					$info['password'] = md5($password);
					extract($info);
					require MOD_ROOT.'api/passport_server_'.$PHPCMS['passport_file'].'.php';
					header('location:'.$url);
                    exit;
				}
				$script = "<script language='javascript'>";
				$script .= "setcookie('username', '".$username."', 0);";
				$script .= "</script>";
                showmessage($LANG['login_success'].$code.$script,$forward);
			}
		}
		else
		{
			$select = array();
			$cookietime = intval(get_cookie('cookietime'));
			$cookietimes = array(0, 86400, 2592000, 31536000);
			foreach($cookietimes as $v)
			{
				$select[$v] = $v == $cookietime ? 'selected' : '';
			}
			$cok_username = get_cookie('username');
			$cok_auth = get_cookie('auth');
			include template('member', 'login');
		}
}
?>