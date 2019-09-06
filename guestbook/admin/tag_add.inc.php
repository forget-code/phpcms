<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$function or showmessage($LANG['attribute_name_not_null'],"goback");
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null'],"goback");
	if($tag->exists($tagname)) showmessage($LANG['label']." ".$tagname." ".$LANG['exist_change_name'],"goback");
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
    if(isset($tagname))
	{
	    $tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
        if($tag->exists($tagname)) showmessage($LANG['tag'].'['.$tagname.']'.$LANG['exists'], '?mod=phpcms&file=tag&action=quickoperate&operate=edit&tagname='.urlencode($tagname));
	}
    include admintpl('tag_'.$function.'_add');
}
?>