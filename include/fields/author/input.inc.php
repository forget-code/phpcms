	function author($field, $value)
	{
		if(empty($value)) return null;
		if(!$this->db->get_one("SELECT `authorid` FROM `".DB_PRE."author` WHERE `name`='$value'"))
		{
			$this->db->query("INSERT INTO ".DB_PRE."author (`name`,`updatetime`) VALUES('$value','".TIME."')");
		}
		return $value;
	}
