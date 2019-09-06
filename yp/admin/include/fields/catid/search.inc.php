    function catid($field, $value)
    {
		$value = get_sql_catid($value);
		$value = str_replace('AND','',$value);
		return $value === '' ? '' : " $value "; 
    }
