   
	function areaid($field, $value)
    {
	     return ($value === '' || !$value) ? '' : " `$field`='$value' "; 
    }