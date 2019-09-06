	function image($field, $value) {
		$value = mysql_real_escape_string(str_replace(array("'",'"','(',')'),'',$value));
		return trim($value);
	}
