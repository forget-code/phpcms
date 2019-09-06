<?php
defined('IN_PHPCMS') or exit('Access Denied');
$PHPCMS['sitename'] = "{$LANG['check_the_same_title']} - $title - ";
if(empty($title))
{
	$message = '<font color="red">'.$LANG['input_the_article_title'].'</font>';
}
else
{
	$result=$db->query("SELECT articleid,title FROM ".channel_table('article', $channelid)." WHERE status=3 AND title LIKE '%$title%'");
	$articles=$db->fetch_array($result);
	if(empty($articles))
	{
		$message = '<font color="blue">'.$LANG['title_not_exists'].'</font>';
	}
	else
	{
		$message = '<font color="red">'.$LANG['title_exists'].'</font>';
	}
}
include admintpl($mod.'_checktitle');
?>