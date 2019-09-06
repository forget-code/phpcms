	function image($field, $value, $fieldinfo)
	{
		global $catid,$PHPCMS,$M;
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"$size\" class=\"$css\" $formattribute/> <input type=\"hidden\" name=\"{$field}_aid\" value=\"0\"> <input type=\"button\" name=\"{$field}_upimage\" id=\"{$field}_upimage\" value=\"上传图片\" style=\"width:60px\" onclick=\"javascript:openwinx('/$M[url]upload_field.php?uploadtext={$field}&formid={$formid}&fieldid={$fieldid}&type=image','upload','450','350')\"/> <input name=\"cutpic\" type=\"button\" id=\"cutpic\" value=\"裁剪图片\" onclick=\"CutPic('$field','$PHPCMS[siteurl]')\"/>";
	}
