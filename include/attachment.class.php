<?php

class attachment
{
	var $db;
    var $attache_urls;
	var $save_urls;
    var $itemid;
	var $keyid;
	var $catid;

	function attachment($itemid = 0, $keyid = 0, $catid = 0)
    {
		global $db;
		if($itemid)
		{	
			$this->init($itemid, $keyid, $catid);
			$this->db = $db;
			$this->save_urls =array();			
		}
        register_shutdown_function(array(&$this, '__destruct'));
    }

    function __destruct()
    {
		unset($this->attach_urls);
		unset($this->save_urls);	
    }

	//private
	function init($itemid, $keyid, $catid)
	{
		$this->itemid = intval($itemid);
		$this->keyid = $keyid;
		$this->catid = intval($catid);
	}

	//private
	function findattachment($content)
	{
		$this->save_urls = array();
        $this->attach_urls = is_array($_SESSION['attachment_urls']) ? $_SESSION['attachment_urls'] : array();
		foreach($this->attach_urls as $url)
		{
			if(strpos($content, $url) === FALSE) //delete the attachment
			{
				@unlink(PHPCMS_ROOT.$url);
			}
			else
			{
				$this->save_urls[] = $url;
			}
		}
	}

	function add($content)
	{
		global $_username,$PHP_TIME;
		$this->findattachment($content);
		foreach($this->save_urls as $url)
		{
			$filesize = filesize(PHPCMS_ROOT.'/'.$url);
			$filetype = fileext(PHPCMS_ROOT.'/'.$url);
			$query = "INSERT INTO ".TABLE_ATTACHMENT."(`username`, `keyid`, `catid` ,`itemid`, `fileurl`,`filetype`,`filesize`,`addtime` ) VALUES('$_username','$this->keyid',$this->catid,$this->itemid,'$url','$filetype','$filesize',$PHP_TIME)";					   
			$this->db->query($query);
		}
        $_SESSION['attachment_urls'] = array();
	}

	//public
	function edit($content)
	{
		$aids = array();
		$result = $this->db->query("SELECT `aid`,`fileurl` FROM ".TABLE_ATTACHMENT." WHERE keyid='$this->keyid' AND itemid=$this->itemid");
		while($r = $this->db->fetch_array($result))
		{
			if(strpos($r['fileurl'], $content) === FALSE)
			{
				$aids[] = $r['aid'];
				@unlink(PHPCMS_ROOT.'/'.$r['fileurl']);				
			}			
		}
		$this->db->free_result($result);
		$aids = implode(',', $aids);
		if($aids) $this->db->query("DELETE FROM ".TABLE_ATTACHMENT." WHERE aid IN($aids)");
		$this->add($content);	
	}

	function delete()
	{
		$lists = $this->get_list();
		foreach($lists as $info)
		{
			@unlink(PHPCMS_ROOT.'/'.$info['fileurl']);
		}
		$this->db->query("DELETE FROM ".TABLE_ATTACHMENT." WHERE keyid='$this->keyid' AND itemid=$this->itemid");
		return $this->db->affected_rows();
	}

	function get_list()
	{
        $lists = array();
		$result = $this->db->query("SELECT * FROM ".TABLE_ATTACHMENT." WHERE keyid='$this->keyid' AND itemid=$this->itemid");
		while($r = $this->db->fetch_array($result))
		{
			$aid = $r['aid'];
			$lists[$aid] = $r;				
		}
		$this->db->free_result($result);
		return $lists;
	}

	function get_info($aid)
	{
		$aid = intval($aid);
		return $this->db->get_one("SELECT * FROM ".TABLE_ATTACHMENT." WHERE aid=$aid");
	}

	//public
	function addfile($file_url)
	{
		$_SESSION['attachment_urls'][] = $file_url;
	}
}
?>