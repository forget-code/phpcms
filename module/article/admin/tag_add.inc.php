<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function or showmessage($LANG['empty_function_name'],"goback");
if($dosubmit)
{
	$tagname or showmessage($LANG['empty_tag_name'],"goback");
	if($tag->exists($tagname)) showmessage($LANG['tag'] .$tagname . $LANG['exists'] . $LANG['change_name'],"goback");
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	showmessage($LANG['operation_success'], $referer);
}
else
{
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	$special_select = str_replace("<select name='specialid' ><option value='0'></option>",'',special_select($channelid, 'specialid',''));
	include admintpl('tag_'.$function.'_add');
}
?>