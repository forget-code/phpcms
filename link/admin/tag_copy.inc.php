<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null'],"goback");
	if($tag->exists($tagname)) showmessage($LANG['label']." ".$tagname." ".$LANG['exist_change_name'],"goback");
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	if($job == 'edittemplate')
	{
		include admintpl('tag_copy_message', 'phpcms');

		$forward = '';
	}
	else
	{
		$message = $LANG['operation_success'];
	}
	showmessage($message, $forward);
}
else
{
	$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
	$tag_config = $tag->get_tag_config($tagname);
	include admintpl('tag_link_list_copy');
}
?>