<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function or showmessage($LANG['function_name_not_null'],"goback");
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
	$TYPE = cache_read('type_'.$mod.'.php');
	$type_select = type_select('type_id',$LANG['select_sub_type'],0,'onchange="document.myform.typeid.value=this.value;"');
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	$brand_select = brand_select('selectbrand_id',0,0,$LANG['select_brand_type'], 'onchange="ChangeInput(this,document.myform.brand_id)"','Id');
    include admintpl('tag_'.$function.'_add');
}
?>