<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MOD['linkurl'].'login.php?forward='.urlencode($PHP_URL));

require_once PHPCMS_ROOT.'/include/field.class.php';
$field = new field($CONFIG['tablepre'].'member_info');

if($dosubmit)
{
	if(!is_email($email)) showmessage($LANG['input_valid_email']);
	$gender = $gender==1 ? 1 : 0;
	$showemail = isset($showemail) ? 1 : 0;
	$byear = intval($byear);
	$byear = $byear==19 ? '0000' : $byear;
	$bmonth = intval($bmonth);
	$bday = intval($bday);

	$birthday = $byear.'-'.$bmonth.'-'.$bday;
	if(!preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $birthday)) $birthday = '0000-00-00';

    if($msn && !is_email($msn)) showmessage($LANG['input_valid_msn'],"goback");
	if(!empty($qq) && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)) showmessage($LANG['input_correct_qq'],"goback");
	if(!empty($postid) && (!is_numeric($postid) || strlen($postid)!=6)) showmessage($LANG['input_correct_zipcode'],"goback");
	if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100) showmessage($LANG['truename_telephoe_etc_not_too_long'],"goback");

	$memberinfo = array('answer'=>$answer,'email'=>$email,'showemail'=>$showemail,'truename'=>$truename,'gender'=>$gender,'birthday'=>$birthday,'idtype'=>$idtype,'idcard'=>$idcard,'province'=>$province,'city'=>$city,'area'=>$area,'industry'=>$industry,'edulevel'=>$edulevel,'occupation'=>$occupation,'income'=>$income,'telephone'=>$telephone,'mobile'=>$mobile,'address'=>$address,'postid'=>$postid,'homepage'=>$homepage,'qq'=>$qq,'msn'=>$msn,'icq'=>$icq,'skype'=>$skype,'alipay'=>$alipay,'paypal'=>$paypal,'userface'=>$userface,'facewidth'=>$facewidth,'faceheight'=>$faceheight,'sign'=>$sign);
	
	$field->check_form();

	$member->edit($memberinfo);

	$field->update("userid=$_userid");

	showmessage($LANG['operation_success'], $PHP_REFERER);
}
else
{
	$memberinfo = $member->get_info();
	$memberinfo = new_htmlspecialchars($memberinfo);
	@extract($memberinfo);

	$birthday = explode("-", $birthday);
	$byear = $birthday[0]=="0000" ? "19" : $birthday[0];
    $bmonth = $birthday[1];
    $bday = $birthday[2];

	$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
	$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

	$fields = $field->get_form('<tr><td class="td_right" width="16%" ><strong>$title:</strong></td><td class="td_left">$input $tool $note</td></tr>');

	$head['title'] = $LANG['member_profile_edit'];
	$head['keywords'] = $LANG['member_profile_edit'];
	$head['description'] = $LANG['member_profile_edit'];

    include template('member', 'edit');
}
?>