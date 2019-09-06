	function groupid($field, $value, $fieldinfo)
	{
		global $GROUP;
		extract($fieldinfo);
		$js = "<script type=\"text/javascript\">
				\$('#selectid').change(function(data){
					\$('#$field').val(\$('#selectid').val());
				});	
			</script>";
		return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\">  ".form::select($GROUP, 'selectid', 'selectid', $value, 'text', 1, $css, '').$js;
	}