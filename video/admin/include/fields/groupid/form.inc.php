	function groupid($field, $value, $fieldinfo)
	{
	    global $priv_group;
		extract($fieldinfo);
		$groupids = '';
		if($value && $this->vid) 
		{
			$groupids = $priv_group->get_groupid('vid', $this->vid, $priv);
			$groupids = implode(',', $groupids);
		}
		return form::select_group('info['.$field.']', $field, $groupids, $cols, $width);
	}
