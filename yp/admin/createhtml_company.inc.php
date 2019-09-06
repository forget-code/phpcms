<?php
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : showmessage($LANG['illegal_parameters']);
$job = $job ? $job : showmessage($LANG['illegal_parameters']);
$job_action = $job;
require PHPCMS_ROOT.'/yp/include/tag.func.php';

switch($action)
{
	case 'showhtml':
	$table = $CONFIG['tablepre'].'yp_'.$job_action;
	$item = $job_action.'id';
	if($job_action=='buy' || $job_action=='sales') $item = 'productid';
	
	if(!is_array($$item)) showmessage($LANG['illegal_parameters']);
	foreach($$item AS $id)
	{
		$r = $db->get_one("SELECT * FROM $table WHERE $item='$id'");
		while (list($key, $value) = each($r))
		{
			$temp[$key] = $value;
		}
		if($job_action=='buy' || $job_action=='sales')
		{
			$product = $temp;
		}
		else
		{
			$$job_action = $temp;
		}
		$$item = $id;
		$companyid = $temp['companyid'];
		extract($db->get_one("SELECT SQL_CACHE m.username,m.userid,c.companyname AS pagename,c.sitedomain AS domainName,c.templateid AS defaultTplType,c.banner,c.background,c.introduce,c.menu FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND m.username=c.username"));	
			
		if($background)
		{
			$backgrounds = explode('|',$background);
			$backgroundtype = $backgrounds[0];
			$background = $backgrounds[1];
		}
		createhtml($job_action);	
	}
	showmessage($LANG['operation_success'],$forward);
	break;
}
?>