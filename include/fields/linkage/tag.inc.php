    function linkage($field, $value)
    {
	     return $value === '' ? '' : '".get_sql_catid('.$value.')."'; 
    }
