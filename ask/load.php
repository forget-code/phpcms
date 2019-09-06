<?php 
require './include/common.inc.php';
$CATEGORY = subcat('ask');
if($id)
{
	$str = "<span style='position:relative;visibility: visible;bottom: 150px;'>→</span>";
	$LANG_SELECT = $LANG['no_select'];
}
else
{
	$str = '';
	$LANG_SELECT = $LANG['please_select'];
}
$str .= '<select onchange="$(\'#catid\').val(this.value);this.disabled=true;category_load(this.value);" multiple style="height:300px;width:120px;"><option value="0" selected>'.$LANG_SELECT.'</option>';
$options = '';
foreach($CATEGORY as $i=>$v)
{
	if((isset($id) && $v['parentid'] == $id) || (isset($module) && $v['module'] == $module))  $options .= '<option value="'.$i.'">'.$v['catname'].'</option>';
}
if(empty($options)) exit;
$str .= $options.'</select>';

echo $str;
?>