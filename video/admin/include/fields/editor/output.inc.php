	function editor($field, $value)
	{
		$data = $this->fields[$field]['storage'] == 'database' ? $value : content_get($this->vid, $field);
		if($this->fields[$field]['enablekeylink'])
		{
			$replacenum = $this->fields[$field]['replacenum'];
			$data = keylinks($data, $replacenum);
		}
		return $data;
	}
