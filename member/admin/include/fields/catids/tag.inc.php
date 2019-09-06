    function catids($field, $value)
    {
	     return $value === '' ? '' : " $field='$value' "; 
    }