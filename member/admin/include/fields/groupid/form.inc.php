	function groupid($field, $value, $fieldinfo)
	{
	    global $GROUP;
		extract($fieldinfo);
		return form::select($GROUP, 'info['.$field.']', $id, $value, $size, $class = '', $ext = '');
	}
