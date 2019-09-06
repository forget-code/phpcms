<?php
defined('IN_PHPCMS') or exit('Access Denied');
require MOD_ROOT.'/include/global.func.php';

$action = $action ? $action : showmessage($LANG['illegal_parameters']);
switch($action)
{
	case 'showhtml':
	$table = $CONFIG['tablepre'].'yp_'.$job;
	$flagid = $job.'id';
	if(!is_array($$flagid)) showmessage($LANG['illegal_parameters']);
	foreach($$flagid AS $id)
	{
		update_url($table,$job,$id,$flagid);
	}
	showmessage($LANG['operation_success'],$forward);
	break;

	case 'buy':
	$table = $CONFIG['tablepre'].'yp_buy';
	$flagid = 'productid';
	if(!is_array($$flagid)) showmessage($LANG['illegal_parameters']);
	foreach($$flagid AS $id)
	{
		update_url($table,'buy',$id,$flagid);
	}
	showmessage($LANG['operation_success'],$forward);
	break;

	case 'sales':
	$table = $CONFIG['tablepre'].'yp_sales';
	$flagid = 'productid';
	if(!is_array($$flagid)) showmessage($LANG['illegal_parameters']);
	foreach($$flagid AS $id)
	{
		update_url($table,'sales',$id,$flagid);
	}
	showmessage($LANG['operation_success'],$forward);
	break;

	case 'company':
		$start = isset($start) ? $start+1 : 0;
		$end = $start + 100;
		if($MOD['enableSecondDomain'])
		{
			$query = "SELECT companyid,sitedomain FROM ".TABLE_MEMBER_COMPANY." ORDER BY companyid LIMIT $start,$end ";
			$result = $db->query($query);
			if($db->num_rows($result)==0) showmessage($LANG['company_linkurl_succss']);
			while($r = $db->fetch_array($result))
			{
				$companyid = $r['companyid'];
				$linkurl = 'http://'.$r['sitedomain'].'.'.$MOD['secondDomain'];
				$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET linkurl='$linkurl' WHERE companyid='$companyid'");
			}
			showmessage($start.'-'.$end.$LANG['update_success'],'?mod='.$mod.'&file='.$file.'&action=company&start='.$end);
		}
		else
		{
			$query = "SELECT companyid,username FROM ".TABLE_MEMBER_COMPANY." ORDER BY companyid LIMIT $start,$end ";
			$result = $db->query($query);
			if($db->num_rows($result)==0) showmessage($LANG['company_linkurl_succss']);
			if(!preg_match("/http:\/\//",$MOD['linkurl']))
			{
				$MOD['linkurl'] = $PHPCMS['siteurl'].'yp/';
			}
			while($r = $db->fetch_array($result))
			{
				extract($db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$r[username]'"));
				$companyid = $r['companyid'];
				$linkurl = $MOD['linkurl']."?".$userid;
				$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET linkurl='$linkurl' WHERE companyid='$companyid'");
			}
			showmessage($start.'-'.$end.$LANG['update_success'],'?mod='.$mod.'&file='.$file.'&action=company&start='.$end);
		}
	break;

	case 'CompanyIndexHtml':
		require MOD_ROOT.'/include/tag.func.php';
		$start = isset($start) ? $start+1 : 0;
		$end = $start + 100;
		if($MOD['enableSecondDomain'])
		{
			$query = "SELECT * FROM ".TABLE_MEMBER_COMPANY." ORDER BY companyid LIMIT $start,$end ";
			$result = $db->query($query);
			if($db->num_rows($result)==0) showmessage($LANG['update_success']);
			while($r = $db->fetch_array($result))
			{
				extract($r);
				$domainName = $sitedomain;
				$defaultTplType = $templateid;
				require MOD_ROOT.'/include/createhtml/index.php';
			}
			showmessage($start.'-'.$end.$LANG['update_success'],'?mod='.$mod.'&file='.$file.'&action=CompanyIndexHtml&start='.$end);
		}
		else
		{
			$query = "SELECT * FROM ".TABLE_MEMBER_COMPANY." WHERE status=3 limit $start,$end ";
			$result = $db->query($query);
			if($db->num_rows($result)==0) showmessage($LANG['update_success']);
			while($r = $db->fetch_array($result))
			{
				extract($r);
				extract($db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$username'"));
				$defaultTplType = $templateid;
				require MOD_ROOT.'/include/createhtml/index.php';
			}
			showmessage($start.'-'.$end.$LANG['update_success'],'?mod='.$mod.'&file='.$file.'&action=CompanyIndexHtml&start='.$end);
		}
	break;
}
?>