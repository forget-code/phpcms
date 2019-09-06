	
	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY,$action,$M;
		if($M['changemode']) return form::select_category('yp', 0, 'catid', 'catid', '请选择所属分类', $value,'onchange="check_catid(this.value)"',2,1);
		extract($fieldinfo);
		$catname = $CATEGORY[$value]['catname'];
		if($value)
		{
			$second_catid = $CATEGORY[$value]['parentid'];
			$firest_catid = $CATEGORY[$second_catid]['parentid'];
			if($firest_catid && $second_catid)
			{
				$catid= $firest_catid;
				$second_option = "<option value='$second_catid' selected>".$CATEGORY[$second_catid]['catname']."</option>";
				$third_option = "<option value='$value' selected>".$CATEGORY[$value]['catname']."</option>";
			}
			elseif($second_catid)
			{
				$catid= $second_catid;
				$second_option = "<option value='$second_catid' selected>".$CATEGORY[$value]['catname']."</option>";
			}
			else
			{
				$catid= $value;
			}
			
		}
		$categorys = '';
		$categorys = '<select name="'.$field.'" id="'.$field.'" onchange="change_f_'.$field.'(this.value)" size="8" style="width:195px;">';
		
		foreach($CATEGORY AS $k=>$v)
		{
			$selected = '';
			if($v['parentid']) continue;
			if($catid == $k) $selected = 'selected';
			$categorys .= "<option value='$k' $selected>$v[catname]</option>";
		}
		$categorys .= '</select>';
		$hava_checked = $value ? 1 : 0;
		$categorys .= ' <select name="secondcatid" size="8" style="width: 195px;" id="secondcatid"  onchange="change_s_'.$field.'(this.value);">'.$second_option.'</select> <select id="thirdcatid" name="thirdcatid" size="8" style="width:195px;" onchange="change_t_'.$field.'(this.value);">'.$third_option.'</select><input type="hidden" id="hava_checked" value="'.$hava_checked.'">';
		return $categorys;
	}
