    function author($field, $value)
    {
	     return $value === '' ? '' : " `$field`='$value' "; 
    }
