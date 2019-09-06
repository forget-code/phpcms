<?php
require './include/common.inc.php';

$jobid = isset($jobid) ? intval($jobid) : exit;
if(!$_userid)
{
	echo "<script language=\"javascript\">alert(\"".$LANG['not_login']."\"); window.location.href='".$PHPCMS['siteurl']."member/login.php';</script>";
	exit;
}
switch($action)
{
	case 'apply':
		$result = $db->get_one("SELECT stockid FROM ".TABLE_YP_STOCK." WHERE jobid='$jobid' AND label=1 AND username='$_username'");
		if($result) 
		{
			echo "<script language=\"javascript\">alert(\"".$LANG['you_have_apply_this_job']."\"); window.close();</script>";
		}
		else
		{
			$db->query("INSERT INTO ".TABLE_YP_STOCK." (jobid,label,username,addtime) VALUES ('$jobid','1','$_username','$PHP_TIME')");
			echo "<script language=\"javascript\">alert(\"".$LANG['applies_successfully']."\"); window.close();</script>";
		}
	break;

	case 'save':
		$result = $db->get_one("SELECT stockid FROM ".TABLE_YP_STOCK." WHERE jobid='$jobid' AND label=0 AND username='$_username'");
		if($result) 
		{
			echo "<script language=\"javascript\">alert(\"".$LANG['have_preserved_this_position']."\"); window.close();</script>";
		}
		else
		{
			$db->query("INSERT INTO ".TABLE_YP_STOCK." (jobid,label,username,addtime) VALUES ('$jobid','0','$_username','$PHP_TIME')");
			echo "<script language=\"javascript\">alert(\"".$LANG['save_successfully']."\"); window.close();</script>";
		}
	break;
}
?>