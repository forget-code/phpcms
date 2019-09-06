<?php 
require dirname(__FILE__).'/include/common.inc.php';

if($field == 'catid')
{
	if($modelid)
	{
		$CATEGORY = submodelcat($modelid);
	}
	$catid = intval($catid);
	$CATEGORY = subcat('phpcms', $catid, 0);
	$str = '<select onchange="$(\'#catid\').val(this.value);this.disabled=true;category_load(this.value);"><option value="0">'.$LANG['please_select'].'</option>';
	$options = '';
	foreach($CATEGORY as $i=>$v)
	{
		if((isset($id) && $v['parentid'] == $id) || (isset($module) && $v['module'] == $module))  $options .= '<option value="'.$i.'">'.$v['catname'].'</option>';
	}
	if(empty($options)) exit;
	$str .= $options.'</select>';
}
elseif($field == 'areaid' && $value)
{
	$str = '<select onchange="$(\'#'.$value.'\').val(this.value);this.disabled=true;area_load(this.value);"><option value="0">'.$LANG['please_select'].'</option>';
	$options = '';
	foreach($AREA as $i=>$v)
	{
		if($v['parentid'] == $id)  $options .= '<option value="'.$i.'">'.$v['name'].'</option>';
	}
	if(empty($options)) exit;
	$str .= $options.'</select>';

}
elseif($field == 'areaid' && !$value)
{
	$str = '<select onchange="$(\'#areaid\').val(this.value);this.disabled=true;areaid_load(this.value);"><option value="0">'.$LANG['please_select'].'</option>';
	$options = '';
	foreach($AREA as $i=>$v)
	{
		if($v['parentid'] == $id)  $options .= '<option value="'.$i.'">'.$v['name'].'</option>';
	}
	if(empty($options)) exit;
	$str .= $options.'</select>';

}
echo $str;
?>