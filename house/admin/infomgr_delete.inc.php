<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(isset($houseids) && is_array($houseids))
{
	$houseid = implode(',',$houseids);
}
else if(isset($houseid))
{
	$houseid= intval($houseid);
}

$result = $db->query("select * from ".TABLE_HOUSE." WHERE houseid IN ($houseid)");
while($r = $db->fetch_array($result))
{
	if($r['ishtml'])
	{
		$filepath = house_item_url('path', $r['ishtml'],$r['urlruleid'], $r['htmldir'], $r['prefix'], $r['houseid'], $r['addtime']);		
		$filepath = PHPCMS_ROOT.'/'.$filepath;
		@unlink($filepath);
	}
}
$db->query("delete from ".TABLE_HOUSE." WHERE houseid IN ($houseid)");
if($MOD['ishtml']) createhtml('index');
if($MOD['createlistinfo']) {$infocat = $typeid; createhtml("listinfo");}
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage&typeid=$typeid");
?>