<?php
defined('IN_PHPCMS') or exit('Access Denied');
$PHPCMS['sitename'] = $LANG['check_same_name']." - $title - ";
if(empty($title))
{
	$message = '<font color="red">'.$LANG['input_title_downlaods'].'</font>';
}
else
{
	$result=$db->query("SELECT downid,title FROM ".channel_table('down', $channelid)." WHERE status=3 AND title LIKE '%$title%'");
	$downs=$db->fetch_array($result);
	if(empty($downs))
	{
		$message = '<font color="blue">'.$LANG['title_not_exist'].'</font>';
	}
	else
	{
		$message = '<font color="red">'.$LANG['heading_already_exist'].'</font>';
	}
}
include admintpl($mod.'_checktitle');
?>