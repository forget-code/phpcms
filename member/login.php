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
			include template('member', 'login_form');
		}
		$CONFIG['phpcache'] = 0;
        phpcache(1);
		break;

    default:
		if($dosubmit)
		{
        	checkcode($checkcodestr, $MOD['enablecheckcodeoflogin'], $PHP_REFERER);

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
					extract($info);
					require MOD_ROOT.'/passport/'.$PHPCMS['passport_file'].'.php';
					header('location:'.$url);
                    exit;
				}
                showmessage($LANG['login_success'], $forward);
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