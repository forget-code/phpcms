	function keyword($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$infos = cache_read('keyword.php');
		$data = "<input type=\"button\" value=\"自动获取\" onclick=\"$.post('api/get_keywords.php?number=3&sid='+Math.random()*5, {data:$('#title').val()}, function(data){ $('#keywords').val(data); })\"> <select name='select_keyword' onchange=\"if($('#{$field}').val()==''){ $('#{$field}').val(this.value);}else if($('#{$field}').val().indexOf(this.value)==-1){ $('#{$field}').val($('#{$field}').val()+' '+this.value);}\" style='width:85px'><option>常用关键词</option>";
		foreach($infos as $info)
		{
			$data .= "<option value='{$info}'>{$info}</option>\n";
		}
		$data .= "</select>";
		if(defined('IN_ADMIN')) $data .= " <a href=\"###\" onclick=\"SelectKeyword();\">更多&gt;&gt;</a>";
		return form::text('info['.$field.']', $field, $value, $type, $size, $css, $formattribute).$data;
	}
