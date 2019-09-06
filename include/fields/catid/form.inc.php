	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY,$action;
		extract($fieldinfo);
		$catname = $CATEGORY[$value]['catname'];
		$publishCats = '';
		if(defined('IN_ADMIN') && $action=='add') $publishCats = "<a href='' class=\"jqModal\" onclick=\"$('.jqmWindow').show();\"/> [同时发布到其他栏目]</a>";
		return "<input type=\"hidden\" name=\"info[$field]\" id=\"$field\" value=\"$value\">$catname $publishCats";
	}
