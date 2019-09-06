	function posid($field, $value, $fieldinfo)
	{
	    $POS = cache_read('position.php');
		extract($fieldinfo);
		array_unshift($POS, '请选择');
		return form::select($POS, 'info['.$field.']', $field, $value);
	}
