<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function or showmessage($LANG['function_name_not_null'],"goback");
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null'],"goback");
	if(!$tag->exists($tagname)) showmessage($LANG['label']." $tagname ".$LANG['not_exist'],"goback");
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	tag_write($mod,$tagname);
	showmessage($LANG['operation_success'], $referer);
}
else
{
	$tag_config = $tag->get_tag_config($tagname);
	include admintpl('tag_changetemplate');
}
?>