	function catid($field, $value)
	{
		global $CATEGORY;
		if(!isset($CATEGORY[$value])) showmessage("所选栏目不存在！");
		return $value;
	}
