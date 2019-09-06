<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function or showmessage($LANG['function_name_not_null'],"goback");
if($dosubmit)
{
	$tagname or showmessage($LANG['label_name_not_null'],"goback");
	if(!$tag->exists($tagname)) showmessage($LANG['label']." ".$tagname." ".$LANG['exist_change_name'],"goback");
	$tag->update($tagname , $tag_config, ''.$function.'('.$tag_funcs[$function].')');
	showmessage($LANG['operation_success'], $referer);
}
else
{	
	$tag_config = $tag->get_tag_config($tagname);
	$tag_config['station'] = isset($tag_config['station']) ? $tag_config['station'] : '';
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	$station_select = '<select id="station" name="tag_config[station]">';
	$station_select .= '<option value="0">'.$LANG['no_limit'].'</option>';
	$station_selects = explode("\n",$MOD['station']);

	foreach($station_selects AS $v)
	{
		$selected = '';
		if($tag_config['station'] == $v) $selected = 'selected="selected"';
		$station_select .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
	}
	$station_select .= '</select>';
	$type_select =type_select('catid','',$tag_config['catid']);
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
	
	include admintpl('tag_'.$function.'_edit');
}
?>