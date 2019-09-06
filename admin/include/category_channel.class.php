<?php 
defined('IN_PHPCMS') or exit('Access Denied');
class category_channel
{
	var $module;
	var $channelid;
	var $catid;
	var $categorys = array();
	var $updatecache = 1;

	function category_channel($channelid, $catid = 0)
	{
		global $CATEGORY,$CHA;
        if(!$channelid) return FALSE;
		$this->module = $CHA['module'];
		$this->channelid = $channelid;
		$this->catid = $catid;
		if(!isset($CATEGORY))
		{
			$CATEGORY = cache_read('categorys_'.$this->channelid.'.php');
		}
		$this->categorys = $CATEGORY;
		register_shutdown_function(array(&$this, '__destruct'));
	}

	function __destruct()
	{
		if($this->updatecache) cache_categorys($this->channelid);
	}

	function add($category, $setting = array())
	{
		global $db;
		if(!is_array($category)) return FALSE;
		$sql1 = $sql2 = $s = '';
		foreach($category as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ',';
		}
		$db->query("INSERT INTO ".TABLE_CATEGORY." ($sql1) VALUES($sql2)");
		
		$this->catid = $db->insert_id();

		if($category['parentid'])
		{
			$category['arrparentid'] = $this->categorys[$category['parentid']]['arrparentid'].",".$category['parentid'];
			$category['parentdir'] = $this->categorys[$category['parentid']]['parentdir'].$this->categorys[$category['parentid']]['catdir']."/";
			$parentids = explode(',', $category['arrparentid']);
			foreach($parentids as $parentid)
			{
				if($parentid)
				{
					$arrchildid = $this->categorys[$parentid]['arrchildid'].','.$this->catid;
					$db->query("UPDATE ".TABLE_CATEGORY." SET child=1,arrchildid='$arrchildid' WHERE catid='$parentid'");
				}
			}
		}
		else
		{
			$category['arrparentid'] = '0';
			$category['parentdir'] = '/';
		}

		$arrparentid = $category['arrparentid'];
		$parentdir = $category['parentdir'];
		$catdir = $category['catdir'];
		$db->query("UPDATE ".TABLE_CATEGORY." SET arrchildid='$this->catid',listorder=$this->catid,arrparentid='$arrparentid',parentdir='$parentdir' WHERE catid=$this->catid");
		$this->setting($setting);
        cache_category($this->catid);
		return TRUE;
	}

	function edit($category, $setting = array())
	{
		global $db;
		$parentid = $category['parentid'];
        $oldparentid = $this->categorys[$this->catid]['parentid'];
		if($parentid != $oldparentid)
		{
			$this->move($parentid, $oldparentid);
		}
		$sql = $s = '';
		foreach($category as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ',';
		}
		$db->query("UPDATE ".TABLE_CATEGORY." SET $sql WHERE catid=$this->catid");
		$this->update_linkurl($this->catid);
		$this->setting($setting);
		$this->repair($this->catid);
        cache_category($this->catid);
		return TRUE;
	}

	function delete()
	{
		global $db;
		if(!array_key_exists($this->catid, $this->categorys)) return FALSE;
        $arrparentid = $this->categorys[$this->catid]['arrparentid'];
        $arrchildid = $this->categorys[$this->catid]['arrchildid'];

		if($this->module == 'article')
		{
			$result = $db->query("SELECT articleid FROM ".channel_table($this->module, $this->channelid)." WHERE catid IN ($arrchildid)");
		    while($r = $db->fetch_array($result))
		    {
			    $db->query("DELETE FROM ".channel_table('article_data', $this->channelid)." WHERE articleid=".$r['articleid']);
		    }
		}
		$db->query("DELETE FROM ".channel_table($this->module, $this->channelid)." WHERE catid IN ($arrchildid)");
		
		$db->query("DELETE FROM ".TABLE_CATEGORY." WHERE catid IN ($arrchildid)");
		$catids = explode(',', $arrchildid);
		foreach($catids as $id)
		{
            unset($this->categorys[$id]);
		}
		if($arrparentid)
		{
		    $arrparentids = explode(',', $arrparentid);
			foreach($arrparentids as $id)
			{
				if($id == 0) continue;
			    $arrchildid = $this->get_arrchildid($id);
			    $child = is_numeric($arrchildid) ? ',child=0' : ',child=1';                   
			    $db->query("UPDATE ".TABLE_CATEGORY." SET arrchildid='$arrchildid' $child WHERE catid='$id'");
			}
		}
        $this->catid = 0;
	}

	function listorder($listorder)
	{
		global $db;
	    if(!is_array($listorder)) return FALSE;
		foreach($listorder as $catid=>$value)
		{
			$value = intval($value);
			$db->query("UPDATE ".TABLE_CATEGORY." SET listorder=$value WHERE catid=$catid");
		}
		return TRUE;
	}

	function disable($value)
	{
		global $db;
		cache_delete('category_'.$this->catid.'.php');
		$db->query("UPDATE ".TABLE_CATEGORY." SET disabled='$value' WHERE catid=$this->catid");
        return $db->affected_rows();
	}

	function get_list()
	{
		global $db;
		$categorys = array();
		$result = $db->query("SELECT catid FROM ".TABLE_CATEGORY." WHERE channelid='$this->channelid' ORDER BY listorder");
		while($r = $db->fetch_array($result))
		{
			$categorys[$r['catid']] = $this->get_info($r['catid']);
		}
		$db->free_result($result);
		$this->updatecache = 0;
		return $categorys;
	}

	function get_info($catid = 0)
	{
		global $db;
		if($catid) $this->catid = $catid;
		$data = $db->get_one("SELECT * FROM ".TABLE_CATEGORY." WHERE catid=$this->catid");
		if($data['setting'])
		{
			$setting = unserialize($data['setting']);
			unset($data['setting']);
			$data = is_array($setting) ? array_merge($data, $setting) : $data;
		}
		unset($data['module']);
		$this->updatecache = 0;
		return $data;
	}

    function update_linkurl($catid)
    {
	    global $db;
		$linkurl = cat_url('url', $catid);
		$db->query("UPDATE ".TABLE_CATEGORY." SET linkurl='$linkurl' WHERE catid=$catid AND islink=0");
        return TRUE;
    }

	function repair()
	{
		global $db;
		if(is_array($this->categorys))
		{
			foreach($this->categorys as $catid => $cat)
			{
				if($catid == 0) continue;
				$this->catid = $catid;
				$arrparentid = $this->get_arrparentid($catid);
				$parentdir = $this->get_parentdir($catid);
				$arrchildid = $this->get_arrchildid($catid);
				$child = is_numeric($arrchildid) ? 0 : 1;
		        $db->query("UPDATE ".TABLE_CATEGORY." SET arrparentid='$arrparentid',parentdir='$parentdir',arrchildid='$arrchildid',child='$child' WHERE catid=$catid");
				$this->update_linkurl($catid);
		        cache_category($catid);
			}
		}
        return TRUE;
	}

	function join($sourcecatid, $targetcatid)
	{
		global $db;
		$arrchildid = $this->categorys[$sourcecatid]['arrchildid'];
		$arrparentid = $this->categorys[$sourcecatid]['arrparentid'];

		$db->query("DELETE FROM ".TABLE_CATEGORY." WHERE catid IN ($arrchildid)");
		$catids = explode(',', $arrchildid);
		foreach($catids as $id)
		{
		    unset($this->categorys[$id]);
		}
		$db->query("UPDATE ".channel_table($this->module, $this->channelid)." SET catid=$targetcatid WHERE catid IN ($arrchildid)");

		if($arrparentid)
		{
		    $arrparentids = explode(',', $arrparentid);
		    foreach($arrparentids as $id)
		    {
				if($id == 0) continue;
				$arrchildid = $this->get_arrchildid($id);
				$child = is_numeric($arrchildid) ? ',child=0' : ',child=1';                   
				$db->query("UPDATE ".TABLE_CATEGORY." SET arrchildid='$arrchildid' $child WHERE catid='$id'");
		    }
		}
	}

	function setting($setting)
	{
		global $db;
		if(!is_array($setting)) return FALSE;
		$setting = addslashes(serialize(new_stripslashes($setting)));
		$db->query("UPDATE ".TABLE_CATEGORY." SET setting='$setting' WHERE catid=$this->catid");
		return TRUE;
	}

	function get_arrparentid($catid, $arrparentid='')
	{
		if(is_array($this->categorys))
		{
			$parentid = $this->categorys[$catid]['parentid'];
			$arrparentid = $arrparentid ? $parentid.",".$arrparentid : $parentid;
			if($parentid)
			{
				$arrparentid = $this->get_arrparentid($parentid,$arrparentid);
			}
			else
			{
				$this->categorys[$catid]['arrparentid'] = $arrparentid;
			}
		}
		return $arrparentid;
	}

	function get_arrchildid($catid)
	{
		$arrchildid = $catid;
		if(is_array($this->categorys))
		{
			foreach($this->categorys as $id => $cat)
			{
				if($cat['parentid'] && $id != $catid)
				{
					$arrparentids = explode(',', $cat['arrparentid']);
					if(in_array($catid,$arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}

	function get_parentdir($catid)
	{
		if($this->categorys[$catid]['parentid']==0) return '/';
		$arrparentid = $this->categorys[$catid]['arrparentid'];
		$arrparentid = explode(",",$arrparentid);
		foreach($arrparentid as $id)
		{
			if($id==0) continue;
			$arrcatdir[$id] = $this->categorys[$id]['catdir'];
		}
		return '/'.implode('/',$arrcatdir).'/';
	}

	function move($parentid, $oldparentid)
	{
		global $db;
		$arrchildid = $this->categorys[$this->catid]['arrchildid'];
		$oldarrparentid = $this->categorys[$this->catid]['arrparentid'];
		$oldparentdir = $this->categorys[$this->catid]['parentdir'];
		$child = $this->categorys[$this->catid]['child'];
		$oldarrparentids = explode(",", $this->categorys[$this->catid]['arrparentid']);
		$arrchildids = explode(",", $this->categorys[$this->catid]['arrchildid']);
		if(in_array($parentid,$arrchildids)) return FALSE;
		
		$this->categorys[$this->catid]['parentid'] = $parentid;

		if($child)
		{
			foreach($arrchildids as $cid)
			{
				if($cid==$this->catid) continue;
				$newarrparentid = $this->get_arrparentid($cid);
				$this->categorys[$cid]['arrparentid'] = $newarrparentid;
				$newparentdir = $this->get_parentdir($cid);
				$db->query("UPDATE ".TABLE_CATEGORY." SET arrparentid='$newarrparentid',parentdir='$newparentdir' WHERE catid='$cid'");
			}
		}
		
		if($parentid)
		{
			$arrparentid = $this->categorys[$parentid]['arrparentid'].",".$parentid;
			$this->categorys[$this->catid]['arrparentid'] = $arrparentid;
			$parentdir = $this->categorys[$parentid]['parentdir'].$r['catdir']."/";
			$arrparentids = explode(",", $arrparentid);
			foreach($arrparentids as $pid)
			{
				if($pid==0) continue;
				$newarrchildid = $this->get_arrchildid($pid);
				$db->query("UPDATE ".TABLE_CATEGORY." SET arrchildid='$newarrchildid',child=1 WHERE catid=$pid");
			}
		}
		else
		{
			$arrparentid = 0;
			$parentdir = '/';
			$this->categorys[$this->catid]['arrparentid'] = $arrparentid;
		}

		$db->query("UPDATE ".TABLE_CATEGORY." SET arrparentid='$arrparentid',parentdir='$parentdir' WHERE catid=$this->catid");
		
		if($oldparentid)
		{
			foreach($oldarrparentids as $pid)
			{
				if($pid==0) continue;
				$oldarrchildid = $this->get_arrchildid($pid);
				$child = is_numeric($oldarrchildid) ? ",child=0" : ",child=1"; 
				$db->query("UPDATE ".TABLE_CATEGORY." SET arrchildid='$oldarrchildid' $child WHERE catid=$pid");
			}
		}
		return TRUE;
	}
}
?>