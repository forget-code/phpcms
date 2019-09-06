<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(isset($displayids) && is_array($displayids))
{
	$displayid = implode(',',$displayids);
}
else if(isset($displayid))
{
	$displayid= intval($displayid);
}
$result = $db->query("select * from ".TABLE_HOUSE_DISPLAY." WHERE displayid IN ($displayid)");
while($r = $db->fetch_array($result))
{
	if($r['ishtml'])
	{
		$filepath = display_item_url('path', $r['ishtml'],$r['urlruleid'], $r['htmldir'], $r['prefix'], $r['displayid'], $r['addtime']);		
		$filepath = PHPCMS_ROOT.'/'.$filepath;
		@unlink($filepath);
	}
}
$db->query("delete from ".TABLE_HOUSE_DISPLAY." WHERE displayid IN ($displayid)");
if($MOD['ishtml']) createhtml('index');
if($MOD['createlistdisplay']) createhtml("listdisplay");
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>