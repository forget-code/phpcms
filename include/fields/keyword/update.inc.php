	function keyword($field, $value)
	{
		$r = $this->db->get_one("SELECT `$field` FROM `".DB_PRE."content` WHERE `contentid`=$this->contentid");
		$value = $r[$field];
		$this->db->query("DELETE FROM `".DB_PRE."content_tag` WHERE `contentid`=$this->contentid");
		$keywords = explode(' ', $value);
		foreach($keywords as $tag)
		{
			$tag = addslashes(trim($tag));
			if($tag) $this->db->query("INSERT INTO `".DB_PRE."content_tag` (`tag`,`contentid`) VALUES('$tag','$this->contentid')");
		}
		return true;
	}
