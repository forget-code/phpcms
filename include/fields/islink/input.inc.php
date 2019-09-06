	function islink($field, $value)
	{
		if($value == '') $value = 99;
		return $value ==99 ? 0 : 1;
	}
