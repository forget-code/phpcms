	
	function image($field, $value, $fieldinfo)
	{
		global $catid;
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$data = $isselectimage ? " <input type='button' value='浏览...' style='cursor:pointer;' onclick=\"file_select('$field', $catid, 1)\">" : '';
		return form::image('info['.$field.']', $field, $value, $size, $css, $formattribute, $modelid, $fieldid).$data;
	}