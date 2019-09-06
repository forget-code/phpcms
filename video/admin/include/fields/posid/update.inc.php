	function posid($field, $value)
	{
		global $action;
		$this->db->query("DELETE FROM `".DB_PRE."video_position` WHERE `vid`='$this->vid'");
		if($value == '-99')
		{
			if($action == 'edit') $this->db->query("UPDATE ".DB_PRE."video SET posids=0 WHERE vid='$this->vid'");
			return false;
		}
		if(is_array($value))
		{
			foreach($value as $posid)
			{
				$posid = intval($posid);
				$this->db->query("INSERT INTO `".DB_PRE."video_position` (`vid`,`posid`) VALUES('$this->vid','$posid')");
			}
		}
		return true;
	}
