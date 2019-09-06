	function file($field, $value, $fieldinfo)
	{
		global $M;
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"$size\" class=\"$css\" $formattribute/> <input type=\"hidden\" name=\"{$field}_aid\" value=\"0\"> <input type=\"button\" name=\"{$field}_upimage\" id=\"{$field}_upimage\" value=\"上传文件\" style=\"width:60px\" onclick=\"javascript:openwinx('/$M[url]upload_field.php?uploadtext={$field}&formid={$formid}&fieldid={$fieldid}&type=file','upload','450','350')\"/>";
	}
