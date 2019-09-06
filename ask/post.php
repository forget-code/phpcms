<?php
require './include/common.inc.php';
$departmentid = intval($departmentid);
if(!$departmentid) showmessage($LANG['illegal_parameters']);
extract($departments[$departmentid]);

if($dosubmit)
{
	if(!isset($checkcode)) $checkcode = '';
	checkcode($checkcode, $MOD['enablecheckcode'], $PHP_REFERER);

	if(strlen($subject) > 255 || empty($subject)) showmessage($LANG['consultation_title_not_null_less_than255']);
	if(strlen($content) > 10000 || empty($content)) showmessage($LANG['consultation_content_not_null_less_than10000']); 

	$departmentid = intval($departmentid);

	$subject = new_htmlspecialchars($subject);
	$truename = new_htmlspecialchars($truename);
	$content = str_safe($content);

	$db->query("insert into ".TABLE_ASK."(departmentid,subject,content,username,ip,addtime) values('$departmentid','$subject','$content','$_username','$PHP_IP','$PHP_TIME')");
	if($db->affected_rows() > 0 )
	{
		require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
		if($point) point_diff($_username, $point, $LANG['consultation_subtract_point']);
		showmessage($LANG['consultation_post_success'], $MOD['linkurl'].'index.php');
	}
	else
	{
		showmessage($LANG['consultation_post_fail_contract_to_administrator']);
	}
}
else
{
	if($point && $_point < $point) showmessage($LANG['your_point_not_enough']." $point ".$LANG['point'], $MODULE['pay']['linkurl'].'point.php?forward='.urlencode($PHP_URL)); 

    $head['title'] = $LANG['want_consultation'];

	include template($mod, 'post'); 
}
?>