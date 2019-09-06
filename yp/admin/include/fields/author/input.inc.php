	function author($field, $value)
	{
		if(empty($value)) return null;
		$this->db->query("REPLACE INTO ".DB_PRE."author (`name`,`updatetime`) VALUES('$value','".TIME."')");
		return $value;
	}
