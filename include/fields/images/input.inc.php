	function images($field, $value)
	{
	    global $PHPCMS,$aids,$mod,$catid,$attachment,$contentid,$MODULE;
		$upload_maxsize = 1024*$this->fields[$field]['upload_maxsize'];
		$addmorepic = $GLOBALS['addmore_'.$field];
		if(!empty($addmorepic) && is_array($addmorepic))
		{
			$attachment->field = $field;
			foreach($addmorepic AS $v)
			{
				if(in_array($v,$GLOBALS['addmore_'.$field.'_delete'])) continue;
				$v = str_replace(UPLOAD_URL,'',$v);
				$filename = basename($v);
				$this->imageexts = $fileext = fileext($filename);
				if(!preg_match("/^(jpg|jpeg|gif|bmp|png)$/", $fileext)) continue;
				$uploadedfile = array('filename'=>$filename, 'filepath'=>$v, 'filetype'=>'', 'filesize'=>'', 'fileext'=>$fileext, 'description'=>'');
				$attachment->add($uploadedfile);
			}
			$is_addmorepic = TRUE;
		}
		if(isset($GLOBALS[$field.'_listorder']))
		{
		    foreach($GLOBALS[$field.'_listorder'] as $aid=>$listorder)
		    {
				$attachment->listorder($aid, $listorder);
		    }
		}
		if(isset($GLOBALS[$field.'_delete']))
		{
		    $del_aids = implode(',', $GLOBALS[$field.'_delete']);
			$attachment->delete("`aid` IN($del_aids)");
		}
		if($contentid) $result = $attachment->listinfo("contentid=$contentid AND field='$field'", 'aid');
		$aids = $attachment->upload($field, $this->fields[$field]['upload_allowext'], $upload_maxsize, 1);
		if(!$aids) return ($result || $is_addmorepic) ? 1 : 0;
		require_once 'image.class.php';
		$image = new image();
		foreach($attachment->attachments[$field] as $aid=>$f)
		{
			$img = UPLOAD_URL.$f;
			if($this->fields[$field]['isthumb'])
			{
			    $thumb = $attachment->get_thumb($img);
				$image->thumb($img, $thumb, $this->fields[$field]['thumb_width'], $this->fields[$field]['thumb_height']);
				$attachment->set_thumb($aid);
			}
			if($this->fields[$field]['iswatermark']) $image->watermark($img, '', $PHPCMS['watermark_pos'], $this->fields[$field]['watermark_img'], '', 5, '#ff0000', $PHPCMS['watermark_jpgquality']);
		}

		return 1;
	}
