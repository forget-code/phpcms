    function areaid($field, $value)
    {
	     return $value == 0 ? '' : " `$field`='$value' "; 
    }