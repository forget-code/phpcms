	function template($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::select_template('video','info['.$field.']', $field, $value, '', 'show');
	}
