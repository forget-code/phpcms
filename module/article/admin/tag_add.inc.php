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
		$message = '<script type="text/javascript">
					window.opener.document.myform.content.focus();
					var str = window.opener.document.selection.createRange();
					str.text = "{tag_'.$tagname.'}";
					window.close();
					</script>';
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
    if(isset($tagname))
	{
	    $tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
        if($tag->exists($tagname)) showmessage($LANG['tag'].'['.$tagname.']'.$LANG['exists'], '?mod=phpcms&file=tag&action=quickoperate&operate=edit&tagname='.urlencode($tagname));
	}
	if(!$channelid) $channelid = '$channelid';
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	$special_select = str_replace("<select name='specialid' ><option value='0'></option>",'',special_select($channelid, 'specialid',''));
	include admintpl('tag_'.$function.'_add');
}
?>