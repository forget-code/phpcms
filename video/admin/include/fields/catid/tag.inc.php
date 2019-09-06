    function catid($field, $value)
    {
	     return $value === '' ? '' : '".get_sql_catid('.$value.')."'; 
    }
