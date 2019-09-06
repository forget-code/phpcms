<?php
define('SHOWJS', 1);
require './include/common.inc.php';

if(!isset($forward)) $forward = $PHP_REFERER;
if(!isset($action)) $action = '';

switch($action)
{
    case 'js':
		if($_userid)
		{
			include template('member', 'login_show');
		}
		else
		{
			$select = array();
			$cookietime = intval(getcookie('cookietime'));
			$cookietimes = array(0, 86400, 2592000, 31536000);
			foreach($cookietimes as $v)
			{
				$select[$v] = $v == $cookietime ? 'selected' : '';
			}
			$templateid = $PHPCMS['enableserverpassport'] ? 'login_form-passport' : 'login_form-yp';
			include template('member', $templateid);
		}
		$CONFIG['phpcache'] = 0;
        phpcache(1);
		break;

    default:

		if($PHPCMS['enableserverpassport'])
		{
			$loginurl = $PHPCMS['passport_serverurl'].$PHPCMS['passport_loginurl'];
			if($PHP_QUERYSTRING) $loginurl .= strpos($loginurl, '?') ? '&'.$PHP_QUERYSTRING : '?'.$PHP_QUERYSTRING;
			elseif($username && $password && $dosubmit) $loginurl .= "?username=$username&password=$password&cookietime=$cookietime&dosubmit=1";
			header('location:'.$loginurl);
			exit;
		}

		if($dosubmit)
		{
        	checkcode($checkcodestr, $MOD['enablecheckcodeoflogin'], $PHP_REFERER);
			$pwd = strtoupper(md5($password));
		    $info = $member->login($password, $cookietime);
			
		    if(!$info)
			{
				showmessage($member->errormsg(), $PHP_REFERER);
			}
			else
			{
				$forward = isset($forward) ? linkurl($forward, 1) : $PHP_SITEURL;
				if($PHPCMS['enablepassport'])
	            {
			        $action = 'login';
					if($PHPCMS['passport_charset'] && $PHPCMS['passport_charset'] != $CONFIG['charset'])
					{
						require_once PHPCMS_ROOT.'/include/charset.func.php';
						$info = convert_encoding($CONFIG['charset'], $PHPCMS['passport_charset'], $info);
					}
					extract($info);
					require MOD_ROOT.'/passport/'.$PHPCMS['passport_file'].'.php';
					header('location:'.$url);
                    exit;
				}
				showmessage($LANG['login_success'], $MODULE['member']['linkurl']);
			}
		}
		else
		{
			$select = array();
			$cookietime = intval(getcookie('cookietime'));
			$cookietimes = array(0, 86400, 2592000, 31536000);
			foreach($cookietimes as $v)
			{
				$select[$v] = $v == $cookietime ? 'selected' : '';
			}
			include template('member', 'login');
		}
}
?>