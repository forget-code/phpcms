	
	function catids($field, $value)
	{
		global $CATEGORY;
		if(!$value) return false;
		$_array = explode(',',$value);
		$this->db->query("DELETE FROM `".DB_PRE."yp_relation` WHERE `userid`='$this->userid'");
		
		$r = $this->db->get_one("SELECT `catids` FROM `".DB_PRE."member_company` WHERE `userid`='$this->userid'");
		$catids = explode(',',$r['catids']);
		foreach($catids AS $_v)
		{
			foreach($CATEGORY AS $catid=>$c)
			{
				if(trim($c['catname']) == trim($_v)) break;
			}
			if(trim($_v))
			{
				$this->db->query("UPDATE `".DB_PRE."category` SET `citems`=`citems`-1 WHERE `catid`='$catid'");
			}
		}
		foreach($_array AS $_v)
		{
			foreach($CATEGORY AS $catid=>$c)
			{
				if(trim($c['catname']) == trim($_v)) break;
			}
			if(trim($_v))
			{
				$this->db->query("INSERT INTO `".DB_PRE."yp_relation` (`userid`,`catid`) VALUES ('$this->userid','$catid')");
				$this->db->query("UPDATE `".DB_PRE."category` SET `citems`=`citems`+1 WHERE `catid`='$catid'");
			}
		}
		return true;
	}
