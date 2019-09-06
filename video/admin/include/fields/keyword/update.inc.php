	function keyword($field, $value)
	{
		$r = $this->db->get_one("SELECT `$field` FROM `".DB_PRE."video` WHERE `vid`='$this->vid'");
		$value = $r[$field];
		$this->db->query("DELETE FROM `".DB_PRE."video_tag` WHERE `vid`='$this->vid'");
		$keywords = explode(' ', $value);
		foreach($keywords as $tag)
		{
			$tag = addslashes(trim($tag));
			if($tag) $this->db->query("INSERT INTO `".DB_PRE."video_tag` (`tag`,`vid`) VALUES('$tag','$this->vid')");
		}
		return true;
	}
 
