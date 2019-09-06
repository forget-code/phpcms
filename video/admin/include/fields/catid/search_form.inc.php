	
	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY,$catid;
		extract($fieldinfo);
		return form::select_category('video', 0, 'catid', 'catid', '--搜索所有栏目--', $catid);
    }
