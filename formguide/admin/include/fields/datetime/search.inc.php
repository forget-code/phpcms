	function datetime($field, $value)
	{
		$sql = '';
		if($this->fields[$field]['dateformat'] == 'int')
		{
			if($value['start'])
			{
				$value['start'] = strtotime($value['start']);
				$sql .= "AND `$field`>='$value[start]' ";
			}
			if($value['end'])
			{
				$value['end'] = strtotime($value['end']);
				$sql .= "AND `$field`<='$value[end]' ";
			}
		}
		else
		{
			if($value['start']) $sql .= "AND `$field`>='$value[start]' ";
			if($value['end']) $sql .= "AND `$field`<='$value[end]' ";
		}
		if($sql) $sql = substr($sql, 3);
		return $sql;
	}
