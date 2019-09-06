    
	function posid($field, $value)
    {
		if(!defined('IN_ADMIN')) return false;
		if($value)
		{
			$query = $this->db->query("SELECT `vid` FROM `".DB_PRE."video_position` WHERE `posid`='$value'");
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
	    return ($value === '' || $str_content == '') ? '' : " `vid` IN('$str_content') "; 
    }