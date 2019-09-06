
function catids($field, $value, $fieldinfo)
	{
		global $CATEGORY;
		extract($fieldinfo);
		$CATEGORY = subcat('yp');
		$data = "<select name='info[$field]' id='$field' $size $css $formattribute>";

		foreach($CATEGORY AS $_k=>$_v)
		{
			if($_v['child']) continue;
			$options .= $_v['catname'].'|'.$_k."\n";
			$data .= "<option value='$_k'>$_v[catname]</option>";
		}
		$data .= "</select>";

		return $data;
	}

