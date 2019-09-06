	
	function groupid($field, $value)
	{
		if(!$value) return false;
		$data = array('userid'=>$this->userid, $field=>$value);
		$this->db->update($this->tablename, $data, "userid='$this->userid'");
		return true;
	}
