
function catid($field, $value, $fieldinfo)
{
	global $CATEGORY;
	extract($fieldinfo);
	return form::select_category('video', 0, 'info[catid]', 'catid', '请选择所属分类', $value,$formattribute.' onchange="check_catid(this.value)"',2)."<span id='catiderror'></span>";
}
