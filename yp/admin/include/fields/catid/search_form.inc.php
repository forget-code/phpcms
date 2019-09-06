	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY;
		extract($fieldinfo);
		$js = "<script type=\"text/javascript\">
					function category_load(id)
					{
						\$.get('load.php', { field: 'catid', id: id },
							  function(data){
								\$('#load_$field').append(data);
							  });
					}
					function category_reload()
					{
						\$('#load_$field').html('');
						category_load(0);
					}
					category_load(0);
			</script>";
		if($value)
		{
			$catname = $CATEGORY[$value]['catname'];
			return "<input type=\"hidden\" name=\"$field\" id=\"$field\" value=\"$value\">
			<span onclick=\"this.style.display='none';\$('#reselect_$field').show();\" style=\"cursor:pointer;\">$catname <font color=\"red\">点击重选</font></span>
			<span id=\"reselect_$field\" style=\"display:none;\">
			<span id=\"load_$field\"></span> 
			<a href=\"javascript:category_reload();\">重选</a>
			</span>$js";
		}
		else
		{
			return "<input type=\"hidden\" name=\"$field\" id=\"$field\" value=\"$value\">
			<span id=\"load_$field\"></span>
			<a href=\"javascript:category_reload();\">重选</a>$js";
		}
    }
