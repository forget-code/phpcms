	
	function keyword($field, $value)
	{
		if($value)
		{
			$query = $this->db->query("SELECT `vid` FROM `".DB_PRE."video_tag` WHERE `tag`='$value'");
			while($r = $this->db->fetch_array($query))
			{
				$result[] = $r['vid'];  
			}
			if(!$result) 
			{
				return " `vid` IN ('') ";
			}	
			$str_content = implode(",", $result);
		}
		return ($value === '' || $str_content == '') ? '' : " `vid` IN($str_content) "; 
	}