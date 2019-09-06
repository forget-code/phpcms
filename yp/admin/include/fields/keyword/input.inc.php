	function keyword($field, $value)
	{
		if(!$value)
		{
		    if(extension_loaded('scws'))
	        {
				$data = $this->data['title'].$this->data['description'];
				require_once PHPCMS_ROOT.'api/keyword.func.php';
				$value = get_keywords($data, 2);
			}
		    if(!$value) return '';
		}
		if(strpos($value, ' '))
		{
			$s = ' ';
		}
		elseif(strpos($value, ','))
		{
			$s = ',';
		}
		$keywords = isset($s) ? array_unique(array_filter(explode($s, $value))) : array($value);
		foreach($keywords as $tag)
		{
			$tag = trim($tag);
			if($this->db->get_one("SELECT `tagid` FROM `".DB_PRE."keyword` WHERE `tag`='$tag'"))
			{
				$this->db->query("UPDATE `".DB_PRE."keyword` SET `usetimes`=`usetimes`+1,`lastusetime`=".TIME." WHERE `tag`='$tag'");
			}
			else
			{
				$this->db->query("INSERT INTO `".DB_PRE."keyword` (`tag`,`usetimes`,`lastusetime`) VALUES('$tag','1','".TIME."')");
			}
		}
		return implode(' ', $keywords);
	}
