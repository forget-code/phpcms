	function copyfrom($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$infos = cache_read('copyfrom.php');
		$data = '<select name="select_copyfrom" onchange="$(\'#'.$field.'\').val(this.value)" style="width:75px"><option>常用来源</option>';
		foreach($infos as $info)
		{
			$data .= "<option value='{$info[name]}|{$info[url]}'>{$info[name]}</option>\n";
		}
		$data .= '</select>';
		if(defined('IN_ADMIN')) $data .= ' <a href="###" onclick="SelectCopyfrom();">更多&gt;&gt;</a>';
		return form::text('info['.$field.']', $field, $value, $type, $size, $css, $formattribute).$data;
	}
