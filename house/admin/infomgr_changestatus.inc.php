<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(isset($houseids) && is_array($houseids))
{
	$houseid = implode(',',$houseids);
}
elseif(isset($houseid))
{
	$houseid= intval($houseid);
}
if(!preg_match("/[0-9,]+/", $houseid)) showmessage('请选择信息！');

$status = $status ? 1 : 0;
$db->query("UPDATE ".TABLE_HOUSE." SET status=$status WHERE houseid IN ($houseid)");
if($MOD['houseishtml'])
{
	if(is_numeric($houseid))
	{
		createhtml('showinfo');
	}
	else
	{
		foreach($dids as $houseid)
		{
			createhtml('showinfo');
		}
	}
}

if($MOD['ishtml']) createhtml('index');
if($MOD['createlistinfo']) {$infocat = $typeid; createhtml("listinfo");}
showmessage($LANG['operation_success'], "?mod=$mod&file=$file&typeid=$typeid&action=manage");
?>