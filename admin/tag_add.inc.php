<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function or showmessage($LANG['function_name_not_null']);
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null']);
	if($tag->exists($tagname)) showmessage($LANG['label']." $tagname ".$LANG['exist_change_name']);
	if($function == 'phpcms_cat')
	{
		if(!isset($tag_config['child'])) $tag_config['child'] = 0;
		if(!isset($tag_config['open'])) $tag_config['open'] = 0;
	}
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	showmessage($LANG['operation_success'], $referer);
}
else
{
	$special_select = str_replace("<select name='specialid' ><option value='0'></option>",'',special_select($channelid, 'specialid',''));
    include admintpl('tag_'.$function.'_add');
}
?>