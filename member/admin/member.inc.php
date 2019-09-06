<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once MOD_ROOT.'/include/member.class.php';
require_once MOD_ROOT.'/admin/include/member_admin.class.php';

if(!isset($username)) $username = '';
$member = new member_admin($username);

require_once PHPCMS_ROOT.'/include/field.class.php';
$field = new field($CONFIG['tablepre'].'member_info');

$GROUP = cache_read('member_group.php');

$submenu = array
(
	array($LANG['approval_new_member'], '?mod='.$mod.'&file='.$file.'&action=check'),
	array($LANG['member_manage'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['search_member'], '?mod='.$mod.'&file='.$file.'&action=search'),
	array($LANG['add_member'], '?mod='.$mod.'&file='.$file.'&action=add'),
);

$menu = adminmenu($LANG['member_manage'], $submenu);

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			if(is_badword($username)) showmessage($LANG['username_non_compliant']);
			if(strlen($password)<2 || strlen($password)>20) showmessage($LANG['password_not_less_than_2char_greater_than_20char']);
			if(!is_email($email)) showmessage($LANG['input_valid_email']);
			if(empty($question) || strlen($question)>50) showmessage($LANG['input_password_clue_question']);
			if(empty($answer) || strlen($answer)>50) showmessage($LANG['input_password_clue_answer']);
			$gender = $gender==1 ? 1 : 0;
			$showemail = isset($showemail) ? 1 : 0;
			$byear = intval($byear);
			$byear = $byear==19 ? '0000' : $byear;
			$bmonth = intval($bmonth);
			$bday = intval($bday);

			$birthday = $byear."-".$bmonth."-".$bday;
			if(!preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $birthday)) $birthday = "0000-00-00";

			if($msn && !is_email($msn)) showmessage($LANG['input_valid_msn']);
			if(!empty($qq) && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)) showmessage($LANG['input_correct_qq']);
			if(!empty($postid) && (!is_numeric($postid) || strlen($postid)!=6)) showmessage($LANG['input_correct_zipcode']);
			if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100) showmessage($LANG['truename_telephoe_etc_not_too_long']);
			
			if($member->exists()) showmessage("$username ".$LANG['have_registered']);

			if($MOD['enablemultiregperemail'] == 0 && $member->email_exists($email)) showmessage("$email ".$LANG['have_used_change_one_email']);

            $arrgroupid = isset($arrgroupid) ? ','.implode(',', $arrgroupid).',' : '';

			@extract($member->group($groupid));

			$begindate = date('Y-m-d');
			$date->dayadd($defaultvalidday);
			$enddate = $defaultvalidday == -1 ? '0000-00-00' : $date->get_date();

	        $field->check_form();

			$memberinfo = array('username'=>$username, 'password'=>$password, 'question'=>$question, 'answer'=>$answer,'email'=>$email,'showemail'=>$showemail,'groupid'=>$groupid,'arrgroupid'=>$arrgroupid,'chargetype'=>$chargetype,'point'=>$defaultpoint,'begindate'=>$begindate,'enddate'=>$enddate,
								'truename'=>$truename,'gender'=>$gender,'birthday'=>$birthday,'idtype'=>$idtype,'idcard'=>$idcard,'province'=>$province,'city'=>$city,'area'=>$area,'industry'=>$industry,'edulevel'=>$edulevel,'occupation'=>$occupation,'income'=>$income,'telephone'=>$telephone,'mobile'=>$mobile,'address'=>$address,'postid'=>$postid,'homepage'=>$homepage,'qq'=>$qq,'msn'=>$msn,'icq'=>$icq,'skype'=>$skype,'alipay'=>$alipay,'paypal'=>$paypal,'userface'=>$userface,'facewidth'=>$facewidth,'faceheight'=>$faceheight,'sign'=>$sign);

			if($userid = $member->register($memberinfo))
			{
				$field->update("userid=$userid");
				showmessage($LANG['member_add_success'], $forward);
			}
			else
			{
				showmessage($LANG['register_fail']);
			}
		}
		else
		{
			$begindate = date('Y-m-d', $PHP_TIME);

            $groups = $arrgroups = array();
            foreach($GROUP as $id=>$g)
            {
				$groups[] = $g;
				if($g['grouptype'] != 'system')
				{
					$arrgroups[] = $g;
				}
            }
	        $fields = $field->get_form('<tr><td class="tablerow">$title:</td><td class="tablerow">$input $tool $note</td></tr>');

			include admintpl('member_add');
		}
		break;

    case 'edit':
		if($dosubmit)
		{
			if(!is_email($email)) showmessage($LANG['input_valid_email'],"goback");
			$gender = $gender==1 ? 1 : 0;
			$showemail = (isset($showemail) && $showemail == 1) ? 1 : 0;
			$byear = intval($byear);
			$byear = $byear==19 ? '0000' : $byear;
			$bmonth = intval($bmonth);
			$bday = intval($bday);

			$birthday = $byear."-".$bmonth."-".$bday;
			if(!preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $birthday)) $birthday = "0000-00-00";

			if($msn && !is_email($msn)) showmessage($LANG['input_valid_msn']);
			if(!empty($qq) && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)) showmessage($LANG['input_correct_qq'],"goback");
			if(!empty($postid) && (!is_numeric($postid) || strlen($postid)!=6)) showmessage($LANG['input_correct_zipcode'],"goback");
			if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100) showmessage($LANG['truename_telephoe_etc_not_too_long'],"goback");

            $arrgroupid = isset($arrgroupid) ? ','.implode(',', $arrgroupid).',' : '';
            
			if($ischargebynewgroup)
			{
				@extract($member->group($groupid));
				$begindate = date('Y-m-d');
				$date->dayadd($defaultvalidday);
				$enddate = $defaultvalidday == -1 ? '0000-00-00' : $date->get_date();
				$point = $defaultpoint;
			}

			$sql = $password ? "password='".md5($password)."'," : "";
			$sql .= $answer ? "answer='".md5($answer)."'," : "";

	        $field->check_form();

			$db->query("UPDATE ".TABLE_MEMBER." SET $sql email='$email',showemail='$showemail',groupid='$groupid',arrgroupid='$arrgroupid',question='$question',point='$point',chargetype='$chargetype',begindate='$begindate',enddate='$enddate' WHERE userid='$userid'");
			$db->query("UPDATE ".TABLE_MEMBER_INFO." SET truename='$truename',gender='$gender',birthday='$birthday',idtype='$idtype',idcard='$idcard',province='$province',city='$city',area='$area',industry='$industry',edulevel='$edulevel',occupation='$occupation',income='$income',telephone='$telephone',mobile='$mobile',address='$address',postid='$postid',homepage='$homepage',qq='$qq',msn='$msn',icq='$icq',skype='$skype',alipay='$alipay',paypal='$paypal',userface='$userface',facewidth='$facewidth',faceheight='$faceheight',sign='$sign' WHERE userid=$userid");
		    
			$field->update("userid=$userid");

			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$memberinfo = $member->view('m.userid='.$userid);
			if(!$memberinfo) showmessage($LANG['account_not_exist_or_delete'], $forward);

			extract(new_htmlspecialchars($memberinfo));

			$birthday = explode('-', $birthday);

			$byear = $birthday[0];
			$bmonth = $birthday[1];
			$bday = $birthday[2];

            $groups = $arrgroups = array();
            foreach($GROUP as $id=>$g)
            {
				$groups[] = $g;
				if($g['grouptype'] != 'system')
				{
					$arrgroups[] = $g;
				}
            }

			$arrgroupid = $arrgroupid ? array_filter(explode(',', $arrgroupid)) : array();

	        $fields = $field->get_form('<tr><td class="tablerow">$title:</td><td class="tablerow">$input $tool $note</td></tr>');

			include admintpl('member_edit');
		}
		break;

    case 'view':
	    if(isset($userid))
	    {
			$condition = "m.userid=".intval($userid);
		}
		elseif(isset($username))
    	{
 			$condition = "m.username='$username'";
        }
		else
	    {
			showmessage($LANG['select_account'], $forward);
		}

		$memberinfo = $member->view($condition);
        if(!$memberinfo) showmessage($LANG['account_not_exist_or_delete'], $forward);

		@extract($memberinfo);

		require_once PHPCMS_ROOT.'/include/ip.class.php';
		$ipinfo = new ip;

		$regiparea = $ipinfo->getlocation($regip);
        $regiparea = $regiparea['area'];

		$lastloginiparea = '';
		if($lastloginip)
	    {
			$lastloginiparea = $ipinfo->getlocation($lastloginip);
			$lastloginiparea = $lastloginiparea['area'];
		}

        $old = '';
		if($birthday > '0000-00-00')
		{
			$date->set_date($birthday);
			$old = date('Y') - $date->get_year();
		}

		$arrgroupname = array();
		$arrgroupid = $arrgroupid ? array_filter(explode(',', $arrgroupid)) : array();
		foreach($arrgroupid as $id)
		{
			$arrgroupname[] = $GROUP[$id]['groupname'];
		}
		$arrgroupname = $arrgroupname ? implode(' | ', $arrgroupname) : '';

        $fields = $field->show_list('<tr><td class="tablerowhighlight" align="right">$title :</td><td class="tablerow" colspan=3> $value </td></tr>');

		include admintpl('member_view');

		break;

    case 'delete':

		if(!isset($userid)) showmessage($LANG['select_account'], $forward);

		$member->delete($userid);
		showmessage($LANG['operation_success'], $forward);

		break;

    case 'manage':

		$page = isset($page) ? intval($page) : 1;
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
		$offset = ($page-1)*$pagesize;
		$frommoney = isset($frommoney) ? intval($frommoney) : 0;
		$tomoney = isset($tomoney) ? intval($tomoney) : 0;
		$frompayment = isset($frompayment) ? intval($frompayment) : 0;
		$topayment = isset($topayment) ? intval($topayment) : 0;
		$frompoint = isset($frompoint) ? intval($frompoint) : 0;
		$topoint = isset($topoint) ? intval($topoint) : 0;
		$fromcredit = isset($fromcredit) ? intval($fromcredit) : 0;
		$tocredit = isset($tocredit) ? intval($tocredit) : 0;
        $groupid = isset($groupid) ? intval($groupid) : 0;

        if(!isset($username)) $username = '';
        if(!isset($industry)) $industry = '';
        if(!isset($edulevel)) $edulevel = '';
        if(!isset($income)) $income = '';
        if(!isset($occupation)) $occupation = '';
        if(!isset($province)) $province = '';
        if(!isset($city)) $city = '';

        if(!isset($truename)) $truename = '';
        if(!isset($address)) $address = '';
        if(!isset($qq)) $qq = '';
        if(!isset($email)) $email = '';
        if(!isset($msn)) $msn = '';
        if(!isset($skype)) $skype = '';
        if(!isset($icq)) $icq = '';
        if(!isset($homepage)) $homepage = '';

		$condition = '';
		$condition .= $username ? " and m.username like '%$username%'" : '';
		$condition .= $groupid ? " and (m.groupid=$groupid or m.arrgroupid like '%,$groupid,%')" : '';
		$condition .= $email ? " and m.email='$email'" : '';
		$condition .= $truename ? " and i.truename like '%$truename%'" : '';
		$condition .= $province ? " and i.province='$province'" : '';
		$condition .= $qq ? " and i.qq='$qq'" : '';
		$condition .= $msn ? " and i.msn='$msn'" : '';
		$condition .= $icq ? " and i.icq='$icq'" : '';
		$condition .= $skype ? " and i.skype='$skype'" : '';
		$condition .= $industry ? " and i.industry='$industry'" : '';
		$condition .= $edulevel ? " and i.edulevel='$edulevel'" : '';
		$condition .= $income ? " and i.income='$income'" : '';
		$condition .= $occupation ? " and i.occupation='$occupation'" : '';
		$condition .= $frommoney ? " and m.money>=$frommoney" : '';
		$condition .= $tomoney ? " and m.money<=$tomoney" : '';
		$condition .= $frompayment ? " and m.payment>=$frompayment" : '';
		$condition .= $topayment ? " and m.payment<=$topayment" : '';
		$condition .= $frompoint ? " and m.point>=$frompoint" : '';
		$condition .= $topoint ? " and m.point<=$topoint" : '';
		$condition .= $fromcredit ? " and m.credit>=$fromcredit" : '';
		$condition .= $tocredit ? " and m.credit<=$tocredit" : '';
		$condition .= $city ? " and i.city like '%$city%'" : '';
		$condition .= $homepage ? " and i.homepage like '%$homepage%'" : '';
		$condition .= $address ? " and i.address like '%$address%'" : '';

		$r = $db->get_one("SELECT count(*) as num FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid $condition");
		$pages = phppages($r['num'], $page, $pagesize);

		$members = $member->get_list($condition, $page, $pagesize);

		$groupids = showgroup('select', 'groupid', $groupid);

		require PHPCMS_ROOT.'/include/area.func.php';
        $provinces = province();

		include admintpl('member_manage');

		break;

		case 'check':

        if($dosubmit)
	    {
            $member->check($userid);
            showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
			$page = isset($page) ? intval($page) : 1;
			$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
			$offset = ($page-1)*$pagesize;

			$condition = " AND m.groupid=5";

			$r = $db->get_one("SELECT count(*) as num FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid $condition");
			$pages = phppages($r['num'], $page, $pagesize);

			$members = $member->get_list($condition, $page, $pagesize);

			include admintpl('member_check');
		}

		break;

    case 'lock':

		if(!isset($userid)) showmessage($LANG['select_account'], $forward);

		$member->lock($userid, $val);
		showmessage($LANG['operation_success'], $forward);

		break;

    case 'note':
		if($dosubmit)
		{
			$db->query("UPDATE ".TABLE_MEMBER_INFO." SET note='$note' WHERE userid=$userid");
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$r = $db->get_one("SELECT m.username,i.note FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid	AND m.userid=$userid");
			@extract($r);
			include admintpl('member_note');
		}
	break;

	case 'checkuser':
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
		elseif($member->get_info())
		{
			echo 3;
		}
		elseif($member->get_info())
		{
			echo 4;
		}
		else
		{
			echo 0;
		}
	break;
	case 'search':
		$groupids = showgroup('select', 'groupid', $groupid);

		require PHPCMS_ROOT.'/include/area.func.php';
        $provinces = province();
        include admintpl('member_search');
		break;

	case 'move':
		$userids = is_array($userid) ? implode(',', $userid) : $userid;
	    if(!$userids) showmessage($LANG['select_account'], $PHP_REFERER);

		if($dosubmit)
	    {
			$groupid = intval($groupid);
	        if(!$groupid) showmessage($LANG['select_group'], $PHP_REFERER);

		    $sql = '';
		    if($ischargebynewgroup)
			{
				@extract($member->group($groupid));
				$begindate = date('Y-m-d');
				$date->dayadd($defaultvalidday);
				$enddate = $defaultvalidday == -1 ? '0000-00-00' : $date->get_date();
				$point = $defaultpoint;
				$sql = ",point='$point',chargetype='$chargetype',begindate='$begindate',enddate='$enddate'";
			}
            $db->query("UPDATE ".TABLE_MEMBER." SET groupid=$groupid $sql WHERE userid IN($userids)");
			showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
			$member = array();
			$result = $db->query("SELECT userid,username FROM ".TABLE_MEMBER." WHERE userid IN($userids)");
			while($r = $db->fetch_array($result))
			{
				$member[$r['userid']] = $r['username'];
			}
			$groupids = showgroup('select', 'groupid', $groupid);
			include admintpl('member_move');
		}
		break;

    default :
}
?>