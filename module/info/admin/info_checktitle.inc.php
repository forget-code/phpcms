<?php
defined('IN_PHPCMS') or exit('Access Denied');
$PHPCMS['sitename'] = $LANG['check_if_have_save_name']." - $title - ";
if(empty($title))
{
	$message = '<font color="red">'.$LANG['input_info_title'].'</font>';
}
else
{
	$result=$db->query("SELECT infoid,title FROM ".channel_table('info', $channelid)." WHERE status=3 AND title LIKE '%$title%'");
	$infos=$db->fetch_array($result);
	if(empty($infos))
	{
		$message = '<font color="blue">'.$LANG['title_name_not_exist_can_use'] .'</font>';
	}
	else
	{
		$message = '<font color="red">'.$LANG['title_name_exist_cannot_use_it'].'</font>';
	}
}
include admintpl($mod.'_checktitle');
?>