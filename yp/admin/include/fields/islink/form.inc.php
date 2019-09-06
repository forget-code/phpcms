	function islink($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if($value)
		{
			$linkurl = $this->content_url;
			$disabled = '';
			$checked = 'checked';
		}
		else
		{
			$value = $defaultvalue;
			$disabled = 'disabled';	
			$checked = '';
		}
		$strings = '<input type="hidden" name="info['.$field.']" value="99"><input type="text" name="info[linkurl]" id="linkurl" value="'.$linkurl.'" size="50" maxlength="255" '.$disabled.'> <input name="info['.$field.']" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" '.$checked.'> <font color="#FF0000">转向链接</font><br/><font color="#FF0000">如果使用转向链接则点击标题就直接跳转而内容设置无效</font>';
		return $strings;
	}
