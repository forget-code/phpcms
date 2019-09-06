	function title($field, $value)
	{
		$value = htmlspecialchars($value);
		return output::style($value, $this->content['style']);
	}
