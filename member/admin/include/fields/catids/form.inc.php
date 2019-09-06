	
	function catids($field, $value, $fieldinfo)
	{
		global $CATEGORY;
		extract($fieldinfo);
		$CATEGORY = subcat('yp');
		$selected_values = '';
		if($value)
		{
			$_array_selected = explode(',',$value);
			foreach($_array_selected AS $_array)
			{
				if($_array) $selected_values .= "<option value='$_array'>$_array</option>";
			}
		}
		$data = "<table><tr><td><select name='f_filed_1' id='f_$field' $css $formattribute>";
		foreach($CATEGORY AS $_k=>$_v)
		{
			if(!$_v['child']) $data .= "<option value='$_v[catname]'>$_v[catname]</option>";
		}
		$data .= "</select></td><td><input id='addbutton' type='button' value='添加到列表  >>' disabled style='width:100px;color:#ff0000' onclick=\"transact('update','f_$field','$field');\"><BR><BR>
		<input id='deletebutton' type='button' value='从列表删除  <<' style='width:100px;color:#ff0000' onclick=\"transact('delete','','$field');\"> </td><td><select name=\"info[$field][]\" multiple id='$field' size='8' style='width:195px;'>$selected_values</select></td></tr></table>";

		return $data;
	}
