	function catids($field, $value)
	{
		global $CATEGORY;
		$values = ',';
		foreach($value AS $v)
		{
			$values .= $v.',';
		}
		return $values;
	}
