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
	$TYPE = cache_read('type_'.$mod.'.php');
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	$tagname = '';
	$station = isset($station) ? $station : '';
	$station_select = '<select id="station" name="tag_config[station]">';
	$station_select .= '<option value="0">'.$LANG['no_limit'].'</option>';
	$station_selects = explode("\n",$MOD['station']);

	foreach($station_selects AS $v)
	{
		$selected = '';
		$station_select .= '<option value="'.$v.'" >'.$v.'</option>';
	}
	$station_select .= '</select>';
	$type_select = type_select('catid','');
	$type_select = str_replace("<select name='catid' >",'',$type_select);
	$type_select = str_replace("<option value='0'>分类</option>",'',$type_select);

	$pattern_select = '<select name="selectpattern" onchange="$(\'pattern\').value=this.value">';
	$pattern_select .= '<option value="0">'.$LANG['no_limit'].'</option>';
	$pattern_selects = explode("|",$MOD['pattern']);

	foreach($pattern_selects AS $v)
	{
		$pattern_select .= '<option value="'.$v.'" >'.$v.'</option>';
	}
	$pattern_select .= '</select>';

	$comtype_select = '<select name="selectpattern" onchange="$(\'comtype\').value=this.value">';
	$comtype_select .= '<option value="0">'.$LANG['no_limit'].'</option>';
	$comtype_selects = explode("|",$MOD['comtype']);

	foreach($comtype_selects AS $v)
	{
		$comtype_select .= '<option value="'.$v.'" >'.$v.'</option>';
	}
	$comtype_select .= '</select>';

    include admintpl('tag_'.$function.'_add');
}
?>