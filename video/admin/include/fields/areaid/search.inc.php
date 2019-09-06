   
	function areaid($field, $value)
    {
	     return ($value === '' || !$value) ? '' : " `areaid`='$value' "; 
    }