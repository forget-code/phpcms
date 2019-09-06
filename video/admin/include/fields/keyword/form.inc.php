	function keyword($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$infos = cache_read('keyword.php');
		$data = "<input type=\"button\" value=\"自动获取\" onclick=\"$.post('api/get_keywords.php?number=3&sid='+Math.random()*5, {data:$('#title').val()}, function(data){ $('#keywords').val(data); })\">";
		return form::text('info['.$field.']', $field, $value, $type, $size, $css, $formattribute).$data;
	}
