<?php
defined('IN_PHPCMS') or exit('Access Denied');

$function or showmessage($LANG['function_name_not_null'],"goback");
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null'],"goback");
	if(!$tag->exists($tagname)) showmessage($LANG['label']." ".$tagname." ".$LANG['exist_change_name'],"goback");
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	if($job == 'edittemplate')
	{
		$message = '<script type="text/javascript">window.close();</script>';
		$referer = '';
	}
	else
	{
		$message = $LANG['operation_success'];
	}
	showmessage($message, $referer);
}
else
{
	$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
	$tag_config = $tag->get_tag_config($tagname);
	include admintpl('tag_'.$function.'_edit');
}
?>