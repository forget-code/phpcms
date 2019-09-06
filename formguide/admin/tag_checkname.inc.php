<?php
defined('IN_PHPCMS') or exit('Access Denied');
$PHPCMS['sitename'] = $LANG['check_repeat_label']." - $tagname - ";
if(empty($tagname))
{
	$message = '<font color="red">'.$LANG['input_label_name'].'</font>';
}
else
{
	if($tag->exists($tagname))
	{
		$message = '<font color="red">'.$LANG['label_name_exist_cannot_use_it'].'</font>';
	}
	else
	{
		$message = '<font color="blue">'.$LANG['label_name_not_exist_can_use'].'</font>';
	}
}
include admintpl('tag_checkname');
?>