<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function or showmessage($LANG['function_name_not_null'],"goback");
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null'],"goback");
	if($tag->exists($tagname)) showmessage($LANG['label']." ".$tagname." ".$LANG['exist_change_name'],"goback");
	$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
	showmessage($LANG['operation_success'], $referer);
}
else
{
	require_once PHPCMS_ROOT.'/include/tree.class.php';
    $tree = new tree;

	$TYPE = cache_read('type_'.$mod.'.php');
	$type_select = type_select('type_id','选择子类别',0,'onchange="document.myform.typeid.value=this.value;"');
	$infocat_select = str_replace("<select name='infocat' ><option value='0'></option>",'',infocat_select('infocat'));
    include admintpl('tag_'.$function.'_add');
}
?>