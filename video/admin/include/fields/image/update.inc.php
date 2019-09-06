	function image($field, $value)
	{
		$aid = intval($GLOBALS[$field.'_aid']);
		if($aid < 1) return false;
		$_SESSION['field_image'] = 1;
		return true;
	}
