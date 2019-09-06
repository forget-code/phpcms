<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$function or showmessage($LANG['function_name_not_null']);
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null']);
	if(!$tag->exists($tagname)) showmessage($LANG['label']." $tagname ".$LANG['not_exist']);
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
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	if(isset($tag_config['specialid'])) $special_select = str_replace("<select name='specialid' ><option value='0'></option>",'',special_select($channelid, 'specialid', '', $tag_config['specialid']));
	$AREA = cache_read('areas_'.$channelid.'.php');
	$area_select = str_replace("<select name='areaid' ><option value='0'></option>",'',area_select());
	include admintpl('tag_'.$function.'_edit');
}
?>