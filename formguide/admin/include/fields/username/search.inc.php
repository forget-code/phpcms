	function username($field, $value)
    {
		$query = $this->db->query("SELECT userid FROM ".DB_PRE."member_cache WHERE username LIKE '%$value%'");
		while($r = $this->db->fetch_array($query))
		{
			$result[] = $r['userid'];  
		}
		$str_userid = implode(",", $result);
		if(!$result) return " `userid` IN ('') ";	
		return ($value === '' || $str_userid == '') ? '' : " `userid` IN('$str_userid') "; 
    }