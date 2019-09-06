<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function or showmessage($LANG['empty_function_name'],"goback");
if($dosubmit)
{
	$tagname or showmessage($LANG['empty_tag_name'],"goback");
	if($tag->exists($tagname)) showmessage($LANG['tag'] .$tagname . $LANG['exists'] . $LANG['change_name'],"goback");
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	if($job == 'edittemplate')
	{
		include admintpl('tag_copy_message', 'phpcms');
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
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	if(isset($tag_config['specialid'])) $special_select = str_replace("<select name='specialid' ><option value='0'></option>",'',special_select($channelid, 'specialid', '', $tag_config['specialid']));
	include admintpl('tag_'.$function.'_'.$action);
}
?>