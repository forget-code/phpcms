<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null'],"goback");
	if($tag->exists($tagname)) showmessage($LANG['label']." ".$tagname." ".$LANG['exist_change_name'],"goback");
	if($tag_config['page']) $tag_config['page'] = '$page';
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	if($job == 'edittemplate')
	{
		$message = '<script type="text/javascript">
					window.opener.document.myform.content.focus();
					var str = window.opener.document.selection.createRange();
					str.text = "{tag_'.$tagname.'}";
					window.close();
					</script>';
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
	include admintpl('tag_vote_list_copy');
}
?>