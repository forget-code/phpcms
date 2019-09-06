	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY;
		extract($fieldinfo);
		$js = 'onchange="if($(\'#'.$field.'\').val()){$(\'#'.$field.'\').val(this.value);}else{$(\'#'.$field.'\').val(this.value);}"';
		$select_string = form::select_category('video', 0, 'selectcatid', 'selectcatid', '请选择所属分类', $value,"$js",2);
		return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\">$select_string";
    }
