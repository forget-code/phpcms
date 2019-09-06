	function groupid($field, $value)
	{
		if(!$value || $value=='-99') return false;
		global $priv_group;
		$priv_groupid = array();
		$priv = $this->fields[$field]['priv'];
		foreach($value as $groupid)
		{
		    $priv_groupid[] = $priv.','.$groupid;
		}
		$priv_group->update('vid', $this->vid, $priv_groupid);
		return true;
	}
