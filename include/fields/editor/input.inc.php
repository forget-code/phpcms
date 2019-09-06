	function editor($field, $value)
	{
	    global $attachment;
		if($this->fields[$field]['enablesaveimage']) $value = $attachment->download($field, $value);
		return $value;
	}
