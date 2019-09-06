	function file($field, $value)
	{
		$a_k = urlencode(phpcms_auth("i=-1&m=0&f=$value&mod=formguide", 'ENCODE', AUTH_KEY));
		$result = "<a href='down.php?a_k=$a_k' target='_blank'>点击下载</a>";
		return $value ? $result : '';
	}