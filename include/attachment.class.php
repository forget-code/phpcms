<?php 
class attachment
{
	var $db;
	var $table;
	var $contentid;
	var $module;
	var $catid;
	var $attachments;
	var $field;
	var $imageexts = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
	var $uploadedfiles = array();
	var $downloadedfiles = array();
	var $error;

	function attachment($module = 'phpcms', $catid = 0)
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'attachment';
		$this->module = $module;
		$this->catid = intval($catid);
	}

	function get($aid, $fields = '*')
	{
		$aid = intval($aid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `aid`=$aid");
	}

	function upload($field, $alowexts = 'jpg|jpeg|gif|bmp|png|doc|docx|xls|ppt|pdf|txt|rar|zip', $maxsize = 0, $overwrite = 0)
	{
		global $_groupid;
		if((!UPLOAD_FRONT && $_groupid != 1) || !isset($_FILES[$field])) return false;
		$this->field = $field;
		$this->savepath = UPLOAD_ROOT.date('Y/md/');
		$this->alowexts = $alowexts;
		$this->maxsize = $maxsize;
		$this->overwrite = $overwrite;
		$uploadfiles = array();
		$description = isset($GLOBALS[$field.'_description']) ? $GLOBALS[$field.'_description'] : array();
		if(is_array($_FILES[$field]['error']))
		{
			$this->uploads = count($_FILES[$field]['error']);
			foreach($_FILES[$field]['error'] as $key => $error)
			{
				if($error === UPLOAD_ERR_NO_FILE) continue;
				if($error !== UPLOAD_ERR_OK)
				{
					$this->error = $error;
					return false;
				}
				$uploadfiles[$key] = array('tmp_name' => $_FILES[$field]['tmp_name'][$key], 'name' => $_FILES[$field]['name'][$key], 'type' => $_FILES[$field]['type'][$key], 'size' => $_FILES[$field]['size'][$key], 'error' => $_FILES[$field]['error'][$key], 'description'=>$description[$key]);
			}
		}
		else
		{
			$this->uploads = 1;
			if(!$description) $description = '';
			$uploadfiles[0] = array('tmp_name' => $_FILES[$field]['tmp_name'], 'name' => $_FILES[$field]['name'], 'type' => $_FILES[$field]['type'], 'size' => $_FILES[$field]['size'], 'error' => $_FILES[$field]['error'], 'description'=>$description);
		}
		if(!dir_create($this->savepath))
		{
			$this->error = '8';
			return false;
		}
		if(!is_dir($this->savepath))
		{
			$this->error = '8';
			return false;
		}
		@chmod($this->savepath, 0777);
		if(!is_writeable($this->savepath))
		{
			$this->error = '9';
			return false;
		}

        if(!$this->is_allow_upload())
		{
			$this->error = '13';
  			return false;
		}

		$aids = array();
		foreach($uploadfiles as $k=>$file)
		{
			$fileext = fileext($file['name']);
			if(!preg_match("/^(".$this->alowexts.")$/", $fileext))
			{
				$this->error = '10';
				return false;
			}
			if($this->maxsize && $file['size'] > $this->maxsize)
			{
				$this->error = '11';
				return false;
			}
			if(!$this->isuploadedfile($file['tmp_name']))
			{
				$this->error = '12';
				return false;
			}
			$savefile = $this->savepath.$this->getname($fileext);
			$savefile = preg_replace("/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i", "_\\1\\2", $savefile);
			$filepath = preg_replace("|^".UPLOAD_ROOT."|", "", $savefile);
			if(!$this->overwrite && file_exists($savefile)) continue;
			if(@move_uploaded_file($file['tmp_name'], $savefile) || @copy($file['tmp_name'], $savefile))
			{
				$this->uploadeds++;
				@chmod($savefile, 0644);
				@unlink($file['tmp_name']);
				$uploadedfile = array('filename'=>$file['name'], 'filepath'=>$filepath, 'filetype'=>$file['type'], 'filesize'=>$file['size'], 'fileext'=>$fileext, 'description'=>$file['description']);
				$aids[] = $this->add($uploadedfile);
			}
		}
		return $aids;
	}

	function download($field, $value, $ext = 'gif|jpg|jpeg|bmp|png', $absurl = '', $basehref = '')
	{
		$this->field = $field;
		$dir = date('Y/md/', TIME);
		$uploadpath = PHPCMS_PATH.UPLOAD_URL.$dir;
		$uploaddir = UPLOAD_ROOT.$dir;
		dir_create($uploaddir);
		$string = stripslashes($value);
		if(!preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i", $string, $matches)) return $value;
		$remotefileurls = array();
		foreach($matches[3] as $matche)
		{
			if(DOMAIN && strpos($matche, DOMAIN) !== false) continue;
			$remotefileurls[$matche] = $this->fillurl($matche, $absurl, $basehref);
		}
		unset($matches, $string);
		$remotefileurls = array_unique($remotefileurls);
		$oldpath = $newpath = array();
		foreach($remotefileurls as $k=>$file)
		{
			if(strpos($file, '://') === false) continue;
			$filename = basename($file);
			$newfile = $uploaddir.$filename;
			$upload_func = UPLOAD_FUNC;
			if(@$upload_func($file, $newfile))
			{
				$oldpath[$k] = $file;
				$newpath[$k] = $uploadpath.$filename;
				@chmod($newfile, 0777);
				$fileext = fileext($filename);
				$filetype = '';
				$image_type = 'IMAGETYPE_'.strtoupper($fileext);
				if(defined($image_type) && function_exists('image_type_to_mime_type'))
				{
					$filetype = image_type_to_mime_type(constant($image_type));
				}
				$filepath = $dir.$filename;
				$downloadedfile = array('filename'=>$filename, 'filepath'=>$filepath, 'filetype'=>$filetype, 'filesize'=>filesize($newfile), 'fileext'=>$fileext);
				$aid = $this->add($downloadedfile);
				$this->downloadedfiles[$aid] = $filepath;
			}
		}
		return str_replace($oldpath, $newpath, $value);
	}

	function listinfo($where, $fields = '*', $order = 'listorder,aid', $page = 0, $pagesize = 20)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$limit = '';
		if($page !== 0)
		{
			$page = max(intval($page), 1);
			$offset = $pagesize*($page-1);
			$limit = " LIMIT $offset, $pagesize";
			$r = $this->db->get_one("SELECT count(*) as number FROM $this->table $where");
			$number = $r['number'];
			$this->pages = pages($number, $page, $pagesize);
		}
		$i = 1;
		$array = array();
		$result = $this->db->query("SELECT $fields FROM `$this->table` $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$r['filepath'] = UPLOAD_URL.$r['filepath'];
			$r['thumb'] = $this->get_thumb($r['filepath']);
			$array[$i] = $r;
			$i++;
		}
		$this->number = $this->db->num_rows($result);
		$this->db->free_result($result);
		return $array;
	}

	function add($uploadedfile)
	{
		global $_userid;
		$uploadedfile['field'] = $this->field;
		$uploadedfile['module'] = $this->module;
		$uploadedfile['catid'] = $this->catid;
		$uploadedfile['userid'] = $_userid;
		$uploadedfile['uploadtime'] = TIME;
		$uploadedfile['uploadip'] = IP;
		$uploadedfile['isimage'] = in_array($uploadedfile['fileext'], $this->imageexts) ? 1 : 0;
		$uploadedfile = new_addslashes($uploadedfile);
		$this->db->insert($this->table, $uploadedfile);
		$aid = $this->db->insert_id();
		$uploadedfile['aid'] = $aid;
		$this->uploadedfiles[] = $uploadedfile;
		$this->attachments[$this->field][$aid] = $uploadedfile['filepath'];
		$_SESSION['attachments'][$aid] = $uploadedfile['filepath'];
		return $aid;
	}

	function delete($where)
	{
		$result = $this->db->query("SELECT `filepath`,`isthumb` FROM `$this->table` WHERE $where ORDER BY `aid`");
		while($r = $this->db->fetch_array($result))
		{
			$image = UPLOAD_ROOT.$r['filepath'];
			@unlink($image);
			if($r['isthumb'])
			{
				$thumb = $this->get_thumb($image);
				@unlink($thumb);
			}
		}
		$this->db->free_result($result);
		return $this->db->query("DELETE FROM `$this->table` WHERE $where");
	}

	function listorder($aid, $listorder)
	{
		$aid = intval($aid);
		$listorder = min(intval($listorder), 255);
		return $this->db->query("UPDATE `$this->table` SET `listorder`=$listorder WHERE `aid`=$aid");
	}

	function get_thumb($image)
	{
		return str_replace('.', '_thumb.', $image);
	}

	function set_thumb($aid)
	{
		$aid = intval($aid);
		return $this->db->query("UPDATE `$this->table` SET `isthumb`=1 WHERE `aid`=$aid");
	}

	function is_allow_upload()
	{
		global $_groupid;
        if($_groupid == 1) return true;
		$starttime = TIME-86400;
		$uploads = cache_count("SELECT COUNT(*) AS `count` FROM `$this->table` WHERE `uploadip`='".IP."' AND `uploadtime`>$starttime");
		return ($uploads < UPLOAD_MAXUPLOADS);
	}

	function update($contentid, $field, $html = '')
	{
		if(!isset($this->attachments[$field]) && $html == '') return 0;
		$contentid = intval($contentid);
		$aids = '';
		if($html && isset($_SESSION['attachments']) && empty($_SESSION['downfiles']) && empty($_SESSION['field_images']) && empty($_SESSION['field_image']))
		{
			$aids_del = array();
			foreach($_SESSION['attachments'] as $aid => $url)
			{
				if(!isset($this->downloadedfiles[$aid]) && strpos($html, $url) === false)
				{
					$aids_del[] = $aid;
				}
				else
				{
					$aids[] = $aid;
				}
			}
			if($aids_del)
			{
				$aids_del = implodeids($aids_del);
				$this->delete("`aid` IN($aids_del)");
			}
		}
		else
		{
			if(is_array($this->attachments[$field])) $aids = array_keys($this->attachments[$field]);
		}
		$aids = implodeids($aids);
		if($aids) $this->db->query("UPDATE `$this->table` SET `catid`='$this->catid',`contentid`=$contentid,`field`='$field' WHERE `aid` IN($aids)");
		unset($_SESSION['attachments'],$_SESSION['downfiles'],$_SESSION['field_images']);
		return $aids ? 1 : 0;
	}

	function getname($fileext)
	{
		return date('Ymdhis').rand(100, 999).'.'.$fileext;
	}

	function size($filesize)
	{
		if($filesize >= 1073741824)
		{
			$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
		}
		elseif($filesize >= 1048576)
		{
			$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
		}
		elseif($filesize >= 1024)
		{
			$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
		}
		else
		{
			$filesize = $filesize . ' Bytes';
		}
		return $filesize;
	}

	function isuploadedfile($file)
	{
		return is_uploaded_file($file) || is_uploaded_file(str_replace('\\\\', '\\', $file));
	}

	function fillurl($surl, $absurl, $basehref = '')
	{
		if($basehref != '')
		{
			$preurl = strtolower(substr($surl,0,6));
			if($preurl=='http://' || $preurl=='ftp://' ||$preurl=='mms://' || $preurl=='rtsp://' || $preurl=='thunde' || $preurl=='emule://'|| $preurl=='ed2k://')
			return  $surl;
			else
			return $basehref.'/'.$surl;
		}
		$i = 0;
		$dstr = '';
		$pstr = '';
		$okurl = '';
		$pathStep = 0;
		$surl = trim($surl);
		if($surl=='') return '';
		//判断文档相对于当前的路径
		$urls = @parse_url($absurl);
		$HomeUrl = $urls['host'];
		$BaseUrlPath = $HomeUrl.$urls['path'];
		$BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/",'/',$BaseUrlPath);
		$BaseUrlPath = preg_replace("/\/$/",'',$BaseUrlPath);
		$pos = strpos($surl,'#');
		if($pos>0) $surl = substr($surl,0,$pos);
		if($surl[0]=='/')
		{
			$okurl = 'http://'.$HomeUrl.'/'.$surl;
		}
		elseif($surl[0] == '.')
		{
			if(strlen($surl)<=2) return '';
			elseif($surl[0]=='/')
			{
				$okurl = 'http://'.$BaseUrlPath.'/'.substr($surl,2,strlen($surl)-2);
			}
			else
			{
				$urls = explode('/',$surl);
				foreach($urls as $u)
				{
					if($u=="..") $pathStep++;
					else if($i<count($urls)-1) $dstr .= $urls[$i].'/';
					else $dstr .= $urls[$i];
					$i++;
				}
				$urls = explode('/', $BaseUrlPath);
				if(count($urls) <= $pathStep)
				return '';
				else
				{
					$pstr = 'http://';
					for($i=0;$i<count($urls)-$pathStep;$i++)
					{
						$pstr .= $urls[$i].'/';
					}
					$okurl = $pstr.$dstr;
				}
			}
		}
		else
		{
			$preurl = strtolower(substr($surl,0,6));
			if(strlen($surl)<7)
			$okurl = 'http://'.$BaseUrlPath.'/'.$surl;
			elseif($preurl=="http:/"||$preurl=='ftp://' ||$preurl=='mms://' || $preurl=="rtsp://" || $preurl=='thunde' || $preurl=='emule:'|| $preurl=='ed2k:/')
			$okurl = $surl;
			else
			$okurl = 'http://'.$BaseUrlPath.'/'.$surl;
		}
		$preurl = strtolower(substr($okurl,0,6));
		if($preurl=='ftp://' || $preurl=='mms://' || $preurl=='rtsp://' || $preurl=='thunde' || $preurl=='emule:'|| $preurl=='ed2k:/')
		{
			return $okurl;
		}
		else
		{
			$okurl = eregi_replace("^(http://)",'',$okurl);
			$okurl = eregi_replace("/{1,}",'/',$okurl);
			return 'http://'.$okurl;
		}
	}

	function error()
	{
		$UPLOAD_ERROR = array(
		0 => '文件上传成功',
		1 => '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值',
		2 => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
		3 => '文件只有部分被上传',
		4 => '没有文件被上传',
		5 => '',
		6 => '找不到临时文件夹。',
		7 => '文件写入临时文件夹失败',
		8 => '附件目录创建不成功',
		9 => '附件目录没有写入权限',
		10 => '不允许上传该类型文件',
		11 => '文件超过了管理员限定的大小',
		12 => '非法上传文件',
		13 => '24小时内上传附件个数超出了系统限制',
		);
		return $UPLOAD_ERROR[$this->error];
	}
}
?>