	function copyfrom($field, $value)
	{
		if(!$value) return '';
		if(strpos($value, '|'))
		{
			$copyfrom = explode('|', $value);
			$name = $copyfrom[0];
			$url = $copyfrom[1];
		}
		else
		{
			$name = $value;
			$url = '';
		}
		if($this->db->get_one("SELECT `name` FROM `".DB_PRE."copyfrom` WHERE `name`='$name'"))
		{
			$this->db->query("UPDATE `".DB_PRE."copyfrom` SET `url`='$url',`usetimes`=`usetimes`+1,`updatetime`='".TIME."' WHERE `name`='$name'");
		}
		else
		{
			$this->db->query("INSERT INTO `".DB_PRE."copyfrom` (`name`,`url`,`usetimes`,`updatetime`) VALUES('$name','$url','1','".TIME."')");
		}
		return $value;
	}
