	function file($field, $value)
	{
		global $PHPCMS,$aids,$mod,$catid,$attachment,$vid;
		$upload_maxsize = 1024*$this->fields[$field]['upload_maxsize'];
		if($vid) $result = $attachment->listinfo("vid=$vid AND field='$field'", 'aid');
		$aids = $attachment->upload($field, $this->fields[$field]['upload_allowext'], $upload_maxsize, 1);
		if(!$aids) return $result ? 1 : 0;
		return UPLOAD_URL.$attachment->attachments[$field][$aids[0]];
	}
