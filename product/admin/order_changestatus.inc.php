<?php
defined('IN_PHPCMS') or exit('Access Denied');


//改变状态
$jobs = array('isverify','ispay','isship');
$jobstime = array('verifytime','paytime','shiptime');
$checkusers = array('verifyuser','payuser','shipuser');
if(!in_array($job,$jobs)) showmessage($LANG['illegal_action']);
foreach($jobs as $k =>$v)
{
	if($v == $job)
	{
		$jobtime=$jobstime[$k];
		$checkuser = $checkusers[$k];
		break;
	}
}
if(isset($odr_ids) && is_array($odr_ids))
{
	foreach ($odr_ids as $odr_id)
	{
		$query = "SELECT $job FROM ".TABLE_PRODUCT_ORDER." WHERE odr_id=$odr_id";
		$res = $db->get_one($query);
		
		$val = ($res[$job] == 1)? 0 : 1;
		$query = "UPDATE ".TABLE_PRODUCT_ORDER." SET $job = $val ,$jobtime = $PHP_TIME,$checkuser= '".$_username."' WHERE odr_id=$odr_id";
		$db->query($query);		
	}
}
else if(isset($odr_id))
{
	$odr_id= intval($odr_id);
	$query = "SELECT $job FROM ".TABLE_PRODUCT_ORDER." WHERE odr_id=$odr_id";
	$res = $db->get_one($query);
	
	$val = ($res[$job] == 1)? 0 : 1;
	$query = "UPDATE ".TABLE_PRODUCT_ORDER." SET $job = $val ,$jobtime = $PHP_TIME,$checkuser= '".$_username."' WHERE odr_id=$odr_id";
	$db->query($query);
}
else showmessage($LANG['illegal_parameters']);
$forward = $referer == $forward ?"?mod=$mod&file=$file&action=manage": $forward ;
showmessage($LANG['success_change_status'],$forward);
?> 