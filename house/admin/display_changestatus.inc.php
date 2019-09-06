<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(isset($displayids) && is_array($displayids))
{
	$dids = $displayids;
	$displayid = implode(',',$displayids);
}
else if(isset($displayid))
{
	$displayid= intval($displayid);
}
$status = $status ? 1 : 0;
$db->query("UPDATE ".TABLE_HOUSE_DISPLAY." SET status=$status WHERE displayid IN ($displayid)");
if($MOD['displayishtml'])
{
	if(is_numeric($displayid))
	{
		createhtml('newhouse');
	}
	else
	{
		foreach($dids as $displayid)
		{
			createhtml('newhouse');
		}
	}
}
if($MOD['ishtml']) createhtml('index');
if($MOD['createlistdisplay']) createhtml("listdisplay");
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>