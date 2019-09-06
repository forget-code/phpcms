<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['not_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

switch($action)
{
	case 'reg':
	if($MOD['enablecheckcode'])	
	{
		checkcode($checkcodestr,1,$forward);
	}
	if($MOD['ischeck'])	
	{
		$passed = 0;
		$m = $LANG['wait_check'];
	}
	else
	{
		$passed = 1;
		$m = '';
	}
	if(isset($submit))
	{
		if(!ereg('^[01]+$',$linktype))
		{
			showmessage($LANG['illegal_parameters']); 
		}
		if(empty($name))
		{
			showmessage($LANG['input_sitename'],"goback");
		}
		if(empty($url) || $url=='http://')
		{
			showmessage($LANG['inout_url'],"goback");
		}
		$typeid = intval($typeid);
		$db->query("INSERT INTO ".TABLE_LINK." (`typeid` , `linktype` , `name` , `url` , `logo` , `introduce` , `username` , `passed` , `addtime` )  VALUES('$typeid','$linktype','".htmlspecialchars($name)."','".htmlspecialchars($url)."','".htmlspecialchars($logo)."','".htmlspecialchars($introduce)."','$_username','$passed','$PHP_TIME')");
		if($passed)
		{
			require_once PHPCMS_ROOT."/link/include/tag.func.php";
			createhtml("index");
			createhtml("category_list");
		}
		showmessage($LANG['operation_success'].$m,$forward);
	}

	break;
	case 'edit':
	
	if(isset($submit))
	{
		if(!ereg('^[01]+$',$linktype))
		{
			showmessage($LANG['illegal_parameters']); 
		}   
		if(empty($name))
		{
			showmessage($LANG['input_sitename'],"goback");
		}
		if(empty($url) || $url=='http://')
		{
			showmessage($LANG['inout_url'],"goback");
		}
		$typeid = intval($typeid);

		$db->query("UPDATE ".TABLE_LINK." SET typeid = $typeid,name = '".htmlspecialchars($name)."',logo = '".htmlspecialchars($logo)."' ,introduce ='".htmlspecialchars($introduce)."' WHERE username='$_username' AND url='$url'");
		if($db->affected_rows()>0)
		showmessage($LANG['operation_success'],$forward);
		else
		showmessage($LANG['error_url'],'goback');
	}

	break;
}
?>