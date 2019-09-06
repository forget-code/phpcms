<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$function or showmessage($LANG['funtion_name_no_air']);
if($dosubmit)
{
	$tagname or showmessage($LANG['labels_name_no_air']);
	if($tag->exists($tagname)) showmessage($LANG['labels'].$tagname.$LANG['renamed']);
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
	include admintpl('tag_'.$function.'_copy');
}
?>