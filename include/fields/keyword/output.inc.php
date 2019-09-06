	function keyword($field, $value)
	{
	    if($value == '') return '';
		$v = '';
		if(strpos($value, ',')===false)
		{
			$tags = explode(' ', $value);
		}
		else
		{
			$tags = explode(',', $value);
		}
		foreach($tags as $tag)
		{
			$v .= '<a href="tag.php?tag='.urlencode($tag).'" class="keyword">'.$tag.'</a>';
		}
		return $v;
	}
