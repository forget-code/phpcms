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
	$TYPE = cache_read('type_'.$mod.'.php');
	$type_select = type_select('type_id',$LANG['select_sub_type'],0,'onchange="document.myform.typeid.value=this.value;"');
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	$brand_select = brand_select('selectbrand_id',0,0,$LANG['select_brand_type'], 'onchange="ChangeInput(this,document.myform.brand_id)"','Id');
	include admintpl('tag_'.$function.'_copy');
}
?>