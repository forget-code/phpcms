<?php
require './include/common.inc.php';
if(!$M['allowregister']) showmessage('该网站不能注册，请与网站管理员联系');
if($PHPCMS['enableserverpassport'])
{
	$registerurl = $PHPCMS['passport_serverurl'].$PHPCMS['passport_registerurl'];
	if(QUERY_STRING) $registerurl .= strpos($registerurl, '?') ? '&'.QUERY_STRING : '?'.QUERY_STRING;
	header('location:'.$registerurl);
	exit;
}
if($_userid && $action != 'activate') showmessage($LANG['not_allow_register_repeat'],$MODULE['member']['url']);		//当用户以经登录存在$_userid时不得重复登录
if(!$forward) $forward = HTTP_REFERER;
if(!isset($action)) $action = 'register';

switch ($action)
{
	/*进行用户注册*/
	case 'register':
			if($dosubmit)
			{
				
				checkcode($checkcodestr, $M['enablecheckcodeofreg'], $forward);
				if($PHPCMS['uc'])
				{
					extract($memberinfo);
					require MOD_ROOT.'api/passport_server_ucenter.php';
				}
				if(!$userid)
				{
					$userid = $member->register($memberinfo);
				}
				if(!$userid) showmessage($member->msg(), $forward);
				if($M['enablemailcheck'])
				{
					if(!class_exists('sendmail'))
					{
						$sendmail = load('sendmail.class.php');
					}
					$authstr = $member->make_authcode($memberinfo);
					$title = $PHPCMS['sitename'].$LANG['member_register_email_verify'];
					$authurl = url($M['url'], 1)."register.php?action=activate&userid=$userid&authcode=$authstr";
					$content = tpl_data($mod, 'register_mailcheck');
					$sendmail->send($memberinfo['email'], $title, stripslashes($content), $PHPCMS['mail_user']);
				}

				if(!$M['enablemailcheck'] && !$M['enableadmincheck'])
				{
					$script = "<script language='javascript'>";
					$script .= "setcookie('username', '".$memberinfo['username']."', 0);";
					$script .= "</script>";
				}
				if($PHPCMS['enablepassport'])
	            {
					if($PHPCMS['passport_charset'] && $PHPCMS['passport_charset'] != CHARSET)
					{
						$info = str_charset(CHARSET, $PHPCMS['passport_charset'], $memberinfo);
					}
					
					extract($memberinfo);
					$password = md5($memberinfo['password']);
					require MOD_ROOT.'api/passport_server_'.$PHPCMS['passport_file'].'.php';
					header('location:'.$url);
				}
				if($memberinfo['modelid'] && $M['choosemodel'] && !$M['enablemailcheck'] && !$M['enableadmincheck'])
				{
					$result = $member->login($memberinfo['username'], $memberinfo['password']);
					showmessage('开始填写详细资料！'.$script, $M['url'].'register_model.php');
				}
				if($member->msg())
				{
					showmessage($member->msg().$script, SITE_URL);
				}
				else
				{
					showmessage('注册成功！'.$script, SITE_URL);
				}
			}
			else
			{			
				if($M['choosemodel'] && $member->count_model() >= 2 && !$modelid)
				{
					header('Location:'.url($M['url'].'choice_model.php', 1));
					exit;
				}
				if($modelid && !isset($member->MODEL[$modelid])) showmessage('该模型不存在');
				$head['title'] = '新用户注册_'.$PHPCMS['sitename'];
				header("Cache-control: private");
				include template($mod, 'register');
			}
		break;
	/*验证邮件注册登录*/
	case 'activate':
			$result = $member->verify_authcode($userid, $authcode);
			if(!$result) showmessage($member->msg(), HTTP_REFERER);
			showmessage($LANG['mail_verify_success'], $M['url'].'login.php');
		break;
	/*进行用户名检查,用于注册时做用户体验*/
	case 'checkuser':
			if(!$member->is_username($value) || !$member->username_exists($value))
			{
				exit($member->msg());
			}
			else
			{
				if($M['preserve'])
				{
					$PRES = explode(',', $M['preserve']);
					if(in_array($value, $PRES))
					{
						exit('此用户名受保护，不允许注册！');
					}
				}
				exit('success');
			}
		break;
	/*进行邮件检查，用于注册时做用户体验*/
	case 'checkemail':
			if(!is_email($value))
			{
				exit($LANG['input_valid_email']);
			}
			elseif(!$M['allowemailduplicate'] && $member->email_exists($value))
			{
				exit($member->msg());
			}
			else
			{
				exit('success');
			}
		break;
	case 'regagreement':
			exit($M['reglicense']);
		break;

}
?>