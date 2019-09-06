	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY,$action,$priv_role;
		extract($fieldinfo);
		if(defined('IN_ADMIN'))
		{
			$data = "<select name=\"info[$field]\" id=\"$field\">";
			$modelid = $CATEGORY[$value]['modelid'];
			$role_num = 0;
			foreach($CATEGORY AS $C)
			{
				if($C['modelid']==$modelid && $C['child']==0)
				{
					if($priv_role->check('catid', $value, $action))
					{
						if($C['catid']==$value) $tag = 'selected';
						else $tag = '';
						$data .= "<option value=\"".$C['catid']."\" ".$tag.">".$C['catname']."</option>";
						$role_num++;
					}
				}
			}
			if($role_num)
			{
				$data .= "</select><input type=\"hidden\" name=\"old_{$field}\" value=\"$value\">";
			}
			else
			{
				$catname = $CATEGORY[$value]['catname'];
				$data = "<input type=\"hidden\" name=\"info[$field]\" id=\"$field\" value=\"$value\"> $catname";
			}
		}
		else
		{
			$catname = $CATEGORY[$value]['catname'];
			$data = "<input type=\"hidden\" name=\"info[$field]\" id=\"$field\" value=\"$value\"> $catname";
		}
		$publishCats = '';
		if(defined('IN_ADMIN') && $action=='add') $publishCats = "<a href='' class=\"jqModal\" onclick=\"$('.jqmWindow').show();\"/> [同时发布到其他栏目]</a>";
		return $data.' '.$publishCats;
	}