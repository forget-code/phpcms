	
	function editor($field, $value)
	{
	    global $attachment, $_userid, $mod;
		if(!is_a($attachment, 'attachment'))
		{
			require 'attachment.class.php';
			$attachment = new attachment($mod);
		}
		if(!$value) return false;
		$attachment->upload($field, $value);
		return $value;
	}