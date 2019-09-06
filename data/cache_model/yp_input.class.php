<?php
class yp_input
{
	var $modelid;
	var $fields;
	var $data;
	var $isimport;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function yp_input($modelid)
	{
		$this->__construct($modelid);
	}

	function get($data)
	{
		global $_roleid, $MODEL, $_groupid,$action,$G;
		$this->isimport = $isimport;
		if(!$G['allowpost']) showmessage('你所在的用户组没有发表权限');
		$this->data = $data;
		$info = array();
		$debar_filed = array('catid','title','style','thumb','status','islink','description');
		foreach($data as $field=>$value)
		{
			if($data['islink']==1 && !in_array($field,$debar_filed)) continue;
			if(!isset($this->fields[$field]) || check_in($_roleid, $this->fields[$field]['unsetroleids']) || check_in($_groupid, $this->fields[$field]['unsetgroupids'])) continue;
			$name = $this->fields[$field]['name'];
			$minlength = $this->fields[$field]['minlength'];
			$maxlength = $this->fields[$field]['maxlength'];
			$pattern = $this->fields[$field]['pattern'];
			$errortips = $this->fields[$field]['errortips'];
			if(empty($errortips)) $errortips = "$name 不符合要求！";
			$length = strlen($value);
			if($minlength && $length < $minlength && !$isimport) showmessage("$name 不得少于 $minlength 个字符！");
			if($maxlength && $length > $maxlength && !$isimport)
			{
				showmessage("$name 不得超过 $maxlength 个字符！");
			}
			else
			{
				str_cut($value, $maxlength);
			}
			if($pattern && $length && !preg_match($pattern, $value) && !$isimport) showmessage($errortips);
            $checkunique_table = $this->fields[$field]['issystem'] ? DB_PRE.'content' : DB_PRE.'c_'.$MODEL[$this->modelid]['tablename'];
            if($this->fields[$field]['isunique'] && $this->db->get_one("SELECT $field FROM $checkunique_table WHERE `$field`='$value' LIMIT 1") && $action != 'edit') showmessage("$name 的值不得重复！");
			$func = $this->fields[$field]['formtype'];
			if(method_exists($this, $func)) $value = $this->$func($field, $value);
			$info[$field] = $value;
		}
		return $info;
	}

	function areaid($field, $value)
	{
		global $AREA;
		if($value && !isset($AREA[$value])) showmessage("所选地区不存在！");
		return $value;
	}
	function author($field, $value)
	{
		if(empty($value)) return null;
		$this->db->query("REPLACE INTO ".DB_PRE."author (`name`,`updatetime`) VALUES('$value','".TIME."')");
		return $value;
	}
	function box($field, $value)
	{
		if($this->fields[$field]['boxtype'] == 'checkbox') 
		{
			if(!is_array($value) || empty($value)) return false;
			$value = implode(',', $value);
		}
		return $value;
	}
	function catid($field, $value)
	{
		global $CATEGORY;
		if(!isset($CATEGORY[$value])) showmessage("所选栏目不存在！");
		return $value;
	}
	function copyfrom($field, $value)
	{
		if(!$value) return '';
		if(strpos($value, '|'))
		{
			$copyfrom = explode('|', $value);
			$name = $copyfrom[0];
			$url = $copyfrom[1];
		}
		else
		{
			$name = $value;
			$url = '';
		}
		if($this->db->get_one("SELECT `name` FROM `".DB_PRE."copyfrom` WHERE `name`='$name'"))
		{
			$this->db->query("UPDATE `".DB_PRE."copyfrom` SET `url`='$url',`usetimes`=`usetimes`+1,`updatetime`='".TIME."' WHERE `name`='$name'");
		}
		else
		{
			$this->db->query("INSERT INTO `".DB_PRE."copyfrom` (`name`,`url`,`usetimes`,`updatetime`) VALUES('$name','$url','1','".TIME."')");
		}
		return $value;
	}
	function editor($field, $value)
	{
	    global $attachment;
		if($this->fields[$field]['enablesaveimage'] && !$this->isimport) $value = $attachment->download($field, $value);
		return $value;
	}
	function file($field, $value)
	{
		global $PHPCMS,$aids,$mod,$catid,$attachment,$contentid;
		$upload_maxsize = 1024*$this->fields[$field]['upload_maxsize'];
		if($contentid) $result = $attachment->listinfo("contentid=$contentid AND field='$field'", 'aid');
		$aids = $attachment->upload($field, $this->fields[$field]['upload_allowext'], $upload_maxsize, 1);
		if(!$aids) return $result ? 1 : 0;
		return UPLOAD_URL.$attachment->attachments[$field][$aids[0]];
	}
	function groupid($field, $value)
	{
		return $value ? 1 : 0;
	}
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
	function islink($field, $value)
	{
		if($value == '') $value = 99;
		return $value ==99 ? 0 : 1;
	}
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
		foreach($keywords as $tag)
		{
			$tag = trim($tag);
			if($this->db->get_one("SELECT `tagid` FROM `".DB_PRE."keyword` WHERE `tag`='$tag'"))
			{
				$this->db->query("UPDATE `".DB_PRE."keyword` SET `usetimes`=`usetimes`+1,`lastusetime`=".TIME." WHERE `tag`='$tag'");
			}
			else
			{
				$this->db->query("INSERT INTO `".DB_PRE."keyword` (`tag`,`usetimes`,`lastusetime`) VALUES('$tag','1','".TIME."')");
			}
		}
		return implode(' ', $keywords);
	}
	function posid($field, $value)
	{
		return $value && $value != -99 ? 1 : 0;
	}
	function textarea($field, $value)
	{
		if(!$this->fields[$field]['enablehtml']) $value = strip_tags($value);
		return $value;
	}
}
?>