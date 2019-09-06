	function image($field, $value)
	{
		if($value !='')
		{
			$value = '<img src="'.$value.'" border="0">';
		}
		else
		{
			$value = '<img src="images/nopic.gif" border="0">';
		}
		return $value;
	}
