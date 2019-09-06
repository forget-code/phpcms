	function keyword($field, $value)
	{
		if(!$value)
		{
		    if(extension_loaded('scws'))
	        {
				$data = $this->data['title'].$this->data['description'];
				require_once PHPCMS_ROOT.'api/keyword.func.php';
				$value = get_keywords($data, 2);
			}
		    if(!$value) return '';
		}
		if(strpos($value, ' '))
		{
			$s = ' ';
		}
		elseif(strpos($value, ','))
		{
			$s = ',';
		}
		$keywords = isset($s) ? array_unique(array_filter(explode($s, $value))) : array($value);
		return implode(' ', $keywords);
	}
