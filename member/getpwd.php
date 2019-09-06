<?php
require './include/common.inc.php';
if(!$forward) $forward = HTTP_REFERER;
if($_userid) showmessage($LANG['you_have_logined'], $forward);

if($PHPCMS['enableserverpassport'])
{
	$getpasswordurl = $PHPCMS['passport_serverurl'].$PHPCMS['passport_getpasswordurl'];
	$addstr = QUERY_STRING ? QUERY_STRING : 'forward='.HTTP_REFERER;
	$getpasswordurl .= (strpos($getpasswordurl, '?') ? '&' : '?').$addstr;
	header('location:'.$getpasswordurl);
	exit;
}
$seo_title = $LANG['get_password_back'];
$step = isset($step) ? intval($step) : 1;
if(!$action) $action = 'getpwd';

 switch ($action) 
 {
 	case 'getpwd':
 			if($dosubmit)
 			{
 				if($step == 1)
 				{
 					$userid = $member->match_user_email($username, $email);
					if(!$userid) showmessage($member->msg(), $forward);
 					$step = $M['enableQchk'] ? 2 : 3;
					header('location:'.url($M['url'].'getpwd.php?dosubmit=1&step='.$step.'&userid='.$userid, 1));
					exit;
 				}
				if($step == 2 &&  $M['enableQchk'])
				{
					$result = $member->get($userid, 'i.question', 1);
					$question = $result['question'];
					include template($mod, 'getpwd');
				}
 				if($step == 3)
 				{
					if($M['enableQchk'])
					{
 						if(empty($answer)) showmessage($LANG['password_clue_question_not_null'], $forward);
 						$email = $member->verify_answer($userid, $question, $answer);
 						if(!$email) showmessage($member->msg(), $forward);
					}

					$sendmail = load('sendmail.class.php');
					$r = $member->get($userid, 'username, email');
					$username = $r['username'];
					$email = $r['email'];
					$memberinfo = array('username'=>$username);
					$authstr = $member->make_authcode($memberinfo);
					$title = $PHPCMS['sitename'].$LANG['get_password'];
					$authurl = url($M['url'], 1)."getpwd.php?action=getpwd&step=4&userid=$userid&authstr=$authstr";
					$content = tpl_data($mod, 'getpassword_mailcheck');
					$sendmail->send($email,$title, stripslashes($content), $PHPCMS['mail_user']);
					showmessage($LANG['please_login_your_mailbox'], SITE_URL);
 				}
 				if ($step == 4)
 				{
					if(!$member->match_authcode($userid, $authstr)) showmessage($LANG['verify_string_not_correct']);
 					if(!$member->edit_password($userid, $password))
					{
						showmessage($member->msg(), $forward);
					}
					if($PHPCMS['uc'])
					{
						$action = 'editpwd';
						require MOD_ROOT.'api/passport_server_ucenter.php';
					}
					showmessage('修改成功', SITE_URL);
 				}
 			}
 			else
 			{
				if($step == 4)
				{
					if(!$member->match_authcode($userid, $authstr)) showmessage('请获取正确的验证码');
				}
 				include template($mod, 'getpwd');
 			}
 		break;
 }
?>