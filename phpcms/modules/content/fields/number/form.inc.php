	function number($field, $value, $fieldinfo) {
		if(!$value) $value = $defaultvalue;
		return "<input type='text' name='info[$field]' id='$field' value='$value' style='50' {$formattribute} {$css}>";
	}
