	function typeid($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::select_type('yp', 'info['.$field.']', $field, '请选择', $value, '');
	}
