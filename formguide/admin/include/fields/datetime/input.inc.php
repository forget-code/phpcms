	function datetime($field, $value)
	{
		if($this->fields[$field]['dateformat'] == 'int')
		{
			$value = strtotime($value);
		}
		return $value;
	}