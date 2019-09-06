	function number($field, $value)
	{
	    $sql = '';
	    if($value['start']) $sql .= " $field>='$value[start]'";
	    if($value['end']) $sql .= " $field<='$value[end]'";
		return $sql;
	}