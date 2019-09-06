	function posid($field, $value)
	{
	    global $priv_group, $POS;
		if(!isset($POS)) $POS = cache_read('position.php');
		$result = $this->db->select("SELECT `posid` FROM `".DB_PRE."video_position` WHERE `vid`='$this->vid'", 'posid');
		$posids = array_keys($result);
		$value = '';
		foreach($posids as $posid)
		{
			$value .= $POS[$posid].' ';
		}
		return $value;
	}
