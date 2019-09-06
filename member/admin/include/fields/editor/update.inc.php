	function editor($field, $value)
	{
	    global $attachment;
		if(!$value) return false;
		$data = array('userid'=>$this->userid, $field=>$value);
		$this->db->update($this->tablename, $data, "userid='$this->userid'");
		return $attachment->upload($field, $value);
	}