	
	function box($field, $value)
	{
		if($value && is_array($value))
		{
			$values = '';
			foreach($value AS $_k)
			{
				$values .= "'".$_k."',";
			}
			$value = substr($values,0,-1);
			return "`$field` IN ($value)' ";
		}
		else
		{
			return $value === '' ? '' : " `$field`='$value' ";
		}
	}
