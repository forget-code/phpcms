	function typeid($field, $value, $fieldinfo)
	{
		return form::select_type('phpcms', $field, $field, '不限', $value);
	}
