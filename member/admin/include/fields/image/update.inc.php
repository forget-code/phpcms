	function image($field, $value)
	{
		$aid = intval($GLOBALS[$field.'_aid']);
		if($aid < 1) return false;
		return $this->db->query("UPDATE `".DB_PRE."attachment` SET `userid`=$this->userid WHERE `aid`=$aid");
	}
