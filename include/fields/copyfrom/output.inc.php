	function copyfrom($field, $value)
	{
		if(strpos($value, '|'))
		{
			$copyfrom = explode('|', $value);
			$value = '<a href="'.$copyfrom[1].'" target="_blank" class="copyfrom">'.$copyfrom[0].'</a>';
		}
		return $value;
	}
