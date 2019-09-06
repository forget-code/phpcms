<?php
require './include/common.inc.php';

if($PHPCMS['enableserverpassport'])
{
	$registerurl = $PHPCMS['passport_serverurl'].$PHPCMS['passport_registerurl'];
	if($PHP_QUERYSTRING) $registerurl .= strpos($registerurl, '?') ? '&'.$PHP_QUERYSTRING : '?'.$PHP_QUERYSTRING;
	header('location:'.$registerurl);
	exit;
}

if($_userid) showmessage($LANG['not_allow_register_repeat']);
if(!$MOD['enableregister']) showmessage($LANG['sorry_new_register_not_allowed']);

if(!isset($forward)) $forward = $PHP_REFERER;
if(!isset($action)) $action = '';

require_once PHPCMS_ROOT.'/include/field.class.php';
$field = new field($CONFIG['tablepre'].'member_info');

if($dosubmit)
{
	checkcode($checkcodestr, $MOD['enablecheckcodeofreg'], $PHP_REFERER);

	if(is_badword($username)) showmessage($LANG['username_not_accord_with_critizen']);
	if(strlen($password)<4 || strlen($password)>20) showmessage($LANG['password_not_less_than_4_longer_than_20']);
	if(!is_email($email)) showmessage($LANG['input_valid_email']);
	if(empty($question) || strlen($question)>50) showmessage($LANG['input_password_clue_question']);
	if(empty($answer) || strlen($answer)>50) showmessage($LANG['input_password_clue_answer']);
	$gender = $gender==1 ? 1 : 0;
	$showemail = isset($showemail) ? 1 : 0;
	$byear = intval($byear);
	$byear = $byear==19 ? '0000' : $byear;
	$bmonth = intval($bmonth);
	$bday = intval($bday);

	$birthday = $byear.'-'.$bmonth.'-'.$bday;
	if(!preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $birthday)) $birthday = '0000-00-00';

    if($msn && !is_email($msn)) showmessage($LANG['input_valid_msn']);
	if(!empty($qq) && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)) showmessage($LANG['input_correct_qq']);
	if(!empty($postid) && (!is_numeric($postid) || strlen($postid)!=6)) showmessage($LANG['input_correct_zipcode']);
	if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100) showmessage($LANG['truename_telephoe_etc_not_too_long']);
	
	if($member->exists()) showmessage("$username ".$LANG['have_registered']);

	if($MOD['enablemultiregperemail'] == 0 && $member->email_exists($email)) showmessage("$email ".$LANG['have_used_change_one_email']);

    $groupid = $MOD['enablemailcheck'] ? 4 : ($MOD['enableadmincheck'] ? 5 : 6);
	@extract($member->group($groupid));

	$begindate = date('Y-m-d');
	$date->dayadd($defaultvalidday);
	$enddate = $defaultvalidday == -1 ? '0000-00-00' : $date->get_date();

	$field->check_form();

	$memberinfo = array('username'=>$username, 'password'=>$password, 'question'=>$question, 'answer'=>$answer,'email'=>$email,'showemail'=>$showemail,'groupid'=>$groupid,'chargetype'=>$chargetype,'point'=>$defaultpoint,'begindate'=>$begindate,'enddate'=>$enddate,
		                'truename'=>$truename,'gender'=>$gender,'birthday'=>$birthday,'idtype'=>$idtype,'idcard'=>$idcard,'province'=>$province,'city'=>$city,'area'=>$area,'industry'=>$industry,'edulevel'=>$edulevel,'occupation'=>$occupation,'income'=>$income,'telephone'=>$telephone,'mobile'=>$mobile,'address'=>$address,'postid'=>$postid,'homepage'=>$homepage,'qq'=>$qq,'msn'=>$msn,'icq'=>$icq,'skype'=>$skype,'alipay'=>$alipay,'paypal'=>$paypal,'userface'=>$userface,'facewidth'=>$facewidth,'faceheight'=>$faceheight,'sign'=>$sign);

	if($userid = $member->register($memberinfo))
	{
		$field->update("userid=$userid");
		if(isset($MODULE['union'])) include PHPCMS_ROOT.'/union/include/register.inc.php';
		if($MOD['enablemailcheck'])
		{
			require PHPCMS_ROOT.'/include/mail.inc.php';
			$authstr = $member->make_authstr($username);
			$authurl = linkurl($MOD['linkurl'], 1)."register.php?action=mailcheck&username=".urlencode($username)."&authstr=$authstr";
			$title = $PHPCMS['sitename'].$LANG['member_register_email_verify'];
			$content = tpl_data($mod, 'register_mailcheck');
			sendmail($email, $title, stripslashes($content));
			showmessage($LANG['profile_post_success']." $email ".$LANG['please_login_your_mailbox'], $PHP_SITEURL);
		}
		elseif($MOD['enableadmincheck'])
		{
			showmessage($LANG['profile_post_success_waiting_verify'], $PHP_SITEURL);
		}
		else
		{
			$info = $member->login($password, 0);
			$forward = isset($forward) ? linkurl($forward, 1) : $PHP_SITEURL;
			if($PHPCMS['enablepassport'])
			{
				$action = 'login';
				extract($info);
				require MOD_ROOT.'/passport/'.$PHPCMS['passport_file'].'.php';
				header('location:'.$url);
				exit;
			}
			if(isset($MODULE['yp']) && $member_type == 'enterprise') $forward = $MODULE['yp']['linkurl'].'register.php';
			showmessage($LANG['registered_success_login_please'].'...', $forward);
		}
	}
	else
	{
        $member->logout();
		showmessage($LANG['register_fail']);
	}
}
elseif($action == 'mailcheck')
{
	if(!isset($username) || !isset($authstr) || empty($authstr)) showmessage($LANG['illegal_parameters'], $PHP_SITEURL);
	if($member->check_authstr($username, $authstr))
	{
		$groupid = $MOD['enableadmincheck'] ? 5 : 6;
		@extract($member->group($groupid));

		$begindate = date('Y-m-d');
		$date->dayadd($defaultvalidday);
		$enddate = $defaultvalidday == -1 ? '0000-00-00' : $date->get_date();
        $db->query("UPDATE ".TABLE_MEMBER." SET groupid=$groupid,chargetype='$chargetype',point='$defaultpoint',begindate='$begindate',enddate='$enddate' WHERE username='$username'");
		showmessage($LANG['mail_verify_success'], $PHP_SITEURL);
	}
	else
	{
		showmessage($LANG['mail_verify_fail']);
	}
}
elseif($action == 'checkuser')
{
	if(strtolower($CONFIG['charset']) != 'utf-8' && preg_match("/^([\s\S]*?)([\x81-\xfe][\x40-\xfe])([\s\S]*?)/", $username))
	{
		include PHPCMS_ROOT.'/include/charset.func.php';
		$username = convert_encoding('utf-8', $CONFIG['charset'], $username);
        $member->set_username($username);
	}
	if(strlen($username) < 2 || strlen($username) > 20)
	{
		echo 1;
	}
	elseif($member->is_badword($username))
	{
		echo 2;
	}
	elseif($member->is_reg($username))
	{
		echo 3;
	}
	elseif($member->ban_name($username))
	{
		echo 4;
	}
	else
	{
		echo 0;
	}
}
elseif($action == 'checkemail')
{
	if(!is_email($email))
	{
		echo 1;
	}
	elseif(!$MOD['enablemultiregperemail'] && $member->email_exists($email))
	{
		echo 2;
	}
	else
	{
		echo 0;
	}
}
elseif($action == 'register')
{
	$head['title'] = $LANG['member_register'];
	$head['keywords'] = $LANG['member_register'];
	$head['description'] = $LANG['member_register'];

    if(!isset($forward) || $forward == '') $forward = $PHP_SITEURL;

	$fields = $field->get_form('<tr><td class="td_right" width="15%">$title:</td><td>$input $tool $note</td></tr>');

    include template('member', 'register');
}
else
{
	if(!trim($MOD['reglicense'])) header('location:?action=register');

	$head['title'] = $LANG['member_register'];
	$head['keywords'] = $LANG['member_register'];
	$head['description'] = $LANG['member_register'];

    if(!isset($forward)) $forward = $PHP_REFERER;

    include template('member', 'register_license');
}
?>