	function editor($field, $value)
	{
	    global $aids,$attachment;
		if(!$value) return false;
		if($this->fields[$field]['storage'] == 'file')
		{
			content_set($this->vid, $field, stripslashes($value));
		}
		return $attachment->update($this->vid, $field, $value);
	}
