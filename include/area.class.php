<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class area
{
	var $module;
	var $keyid;
	var $areaid;
	var $areas = array();
	var $updatecache = 1;

	function area($keyid, $areaid = 0)
	{
		global $AREA,$CHAANEL;
        if(!$keyid) return FALSE;
		$this->module = is_numeric($keyid) ? $CHAANEL[$keyid]['module'] : $keyid;
		$this->keyid = $keyid;
		$this->areaid = $areaid;
		if(!isset($AREA))
		{
			$AREA = cache_read('areas_'.$this->keyid.'.php');
		}
		$this->areas = $AREA;
		register_shutdown_function(array(&$this, '__destruct'));
	}

	function __destruct()
	{
		if($this->updatecache) cache_areas($this->keyid);
	}

	function add($area, $setting = array())
	{
		global $db;
		if(!is_array($area)) return FALSE;
		$sql1 = $sql2 = $s = '';
		foreach($area as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ',';
		}
		$db->query("INSERT INTO ".TABLE_AREA." ($sql1) VALUES($sql2)");
		
		$this->areaid = $db->insert_id();

		if($area['parentid'])
		{
			$area['arrparentid'] = $this->areas[$area['parentid']]['arrparentid'].",".$area['parentid'];
			$parentids = explode(',', $area['arrparentid']);
			foreach($parentids as $parentid)
			{
				if($parentid)
				{
					$arrchildid = $this->areas[$parentid]['arrchildid'].','.$this->areaid;
					$db->query("UPDATE ".TABLE_AREA." SET child=1,arrchildid='$arrchildid' WHERE areaid='$parentid'");
				}
			}
		}
		else
		{
			$area['arrparentid'] = '0';
		}

		$arrparentid = $area['arrparentid'];
		$db->query("UPDATE ".TABLE_AREA." SET arrchildid='$this->areaid',listorder=$this->areaid,arrparentid='$arrparentid' WHERE areaid=$this->areaid");
		$this->setting($setting);
        cache_area($this->areaid);
		return TRUE;
	}

	function edit($area, $setting = array())
	{
		global $db;
		$parentid = $area['parentid'];
        $oldparentid = $this->areas[$this->areaid]['parentid'];
		if($parentid != $oldparentid)
		{
			$this->move($parentid, $oldparentid);
		}
		$sql = $s = '';
		foreach($area as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ',';
		}
		$db->query("UPDATE ".TABLE_AREA." SET $sql WHERE areaid=$this->areaid");
		$this->update_linkurl($this->areaid);
		$this->setting($setting);
        cache_area($this->areaid);
		return TRUE;
	}

	function delete($del = 1)
	{
		global $db,$MODULE,$CONFIG;
		if(!array_key_exists($this->areaid, $this->areas)) return FALSE;
        $arrparentid = $this->areas[$this->areaid]['arrparentid'];
        $arrchildid = $this->areas[$this->areaid]['arrchildid'];
		if($del)
		{
			$tablename = $MODULE[$this->module]['iscopy'] ? channel_table($this->module, $this->keyid) : $CONFIG['tablepre'].$this->module;
			$db->query("DELETE FROM $tablename WHERE areaid IN ($arrchildid)");
		}
		$db->query("DELETE FROM ".TABLE_AREA." WHERE areaid IN ($arrchildid)");
		$areaids = explode(',', $arrchildid);
		foreach($areaids as $id)
		{
            unset($this->areas[$id]);
		}
		if($arrparentid)
		{
		    $arrparentids = explode(',', $arrparentid);
			foreach($arrparentids as $id)
			{
				if($id == 0) continue;
			    $arrchildid = $this->get_arrchildid($id);
			    $child = is_numeric($arrchildid) ? ',child=0' : ',child=1';                   
			    $db->query("UPDATE ".TABLE_AREA." SET arrchildid='$arrchildid' $child WHERE areaid='$id'");
			}
		}
        $this->areaid = 0;
	}

	function listorder($listorder)
	{
		global $db;
	    if(!is_array($listorder)) return FALSE;
		foreach($listorder as $areaid=>$value)
		{
			$value = intval($value);
			$db->query("UPDATE ".TABLE_AREA." SET listorder=$value WHERE areaid=$areaid");
		}
		return TRUE;
	}

	function disable($value)
	{
		global $db;
		cache_delete('area_'.$this->areaid.'.php');
		$db->query("UPDATE ".TABLE_AREA." SET disabled='$value' WHERE areaid=$this->areaid");
        return $db->affected_rows();
	}

	function get_list()
	{
		global $db;
		$areas = array();
		$result = $db->query("SELECT areaid FROM ".TABLE_AREA." WHERE keyid='$this->keyid' ORDER BY listorder");
		while($r = $db->fetch_array($result))
		{
			$areas[$r['areaid']] = $this->get_info($r['areaid']);
		}
		$db->free_result($result);
		$this->updatecache = 0;
		return $areas;
	}

	function get_info($areaid = 0)
	{
		global $db;
		if($areaid) $this->areaid = $areaid;
		$data = $db->get_one("SELECT * FROM ".TABLE_AREA." WHERE areaid=$this->areaid");
		if($data['setting'])
		{
			$setting = unserialize($data['setting']);
			unset($data['setting']);
			$data = is_array($setting) ? array_merge($data, $setting) : $data;
		}
		$this->updatecache = 0;
		return $data;
	}

    function update_linkurl($areaid)
    {
	    global $db;
		$linkurl = area_url('url', $areaid);
		$db->query("UPDATE ".TABLE_AREA." SET linkurl='$linkurl' WHERE areaid=$areaid");
        return TRUE;
    }

	function repair()
	{
		global $db;
		if(is_array($this->areas))
		{
			foreach($this->areas as $areaid => $area)
			{
				if($areaid == 0) continue;
				$this->areaid = $areaid;
				$arrparentid = $this->get_arrparentid($areaid);
				$arrchildid = $this->get_arrchildid($areaid);
				$child = is_numeric($arrchildid) ? 0 : 1;
		        $db->query("UPDATE ".TABLE_AREA." SET arrparentid='$arrparentid',arrchildid='$arrchildid',child='$child' WHERE areaid=$areaid");
				$this->update_linkurl($areaid);
		        cache_area($areaid);
			}
		}
        return TRUE;
	}

	function setting($setting)
	{
		global $db;
		if(!is_array($setting)) return FALSE;
		$setting = addslashes(serialize(new_stripslashes($setting)));
		$db->query("UPDATE ".TABLE_AREA." SET setting='$setting' WHERE areaid=$this->areaid");
		return TRUE;
	}

	function get_arrparentid($areaid, $arrparentid='')
	{
		if(is_array($this->areas))
		{
			$parentid = $this->areas[$areaid]['parentid'];
			$arrparentid = $arrparentid ? $parentid.",".$arrparentid : $parentid;
			if($parentid)
			{
				$arrparentid = $this->get_arrparentid($parentid,$arrparentid);
			}
			else
			{
				$this->areas[$areaid]['arrparentid'] = $arrparentid;
			}
		}
		return $arrparentid;
	}

	function get_arrchildid($areaid)
	{
		$arrchildid = $areaid;
		if(is_array($this->areas))
		{
			foreach($this->areas as $id => $area)
			{
				if($area['parentid'] && $id != $areaid)
				{
					$arrparentids = explode(',', $area['arrparentid']);
					if(in_array($areaid,$arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}


	function move($parentid, $oldparentid)
	{
		global $db;
		$arrchildid = $this->areas[$this->areaid]['arrchildid'];
		$oldarrparentid = $this->areas[$this->areaid]['arrparentid'];
		$child = $this->areas[$this->areaid]['child'];
		$oldarrparentids = explode(",", $this->areas[$this->areaid]['arrparentid']);
		$arrchildids = explode(",", $this->areas[$this->areaid]['arrchildid']);
		if(in_array($parentid,$arrchildids)) return FALSE;
		
		$this->areas[$this->areaid]['parentid'] = $parentid;

		if($child)
		{
			foreach($arrchildids as $cid)
			{
				if($cid==$this->areaid) continue;
				$newarrparentid = $this->get_arrparentid($cid);
				$this->areas[$cid]['arrparentid'] = $newarrparentid;
				$db->query("UPDATE ".TABLE_AREA." SET arrparentid='$newarrparentid' WHERE areaid='$cid'");
			}
		}
		
		if($parentid)
		{
			$arrparentid = $this->areas[$parentid]['arrparentid'].",".$parentid;
			$this->areas[$this->areaid]['arrparentid'] = $arrparentid;
			$arrparentids = explode(",", $arrparentid);
			foreach($arrparentids as $pid)
			{
				if($pid==0) continue;
				$newarrchildid = $this->get_arrchildid($pid);
				$db->query("UPDATE ".TABLE_AREA." SET arrchildid='$newarrchildid',child=1 WHERE areaid=$pid");
			}
		}
		else
		{
			$arrparentid = 0;
			$this->areas[$this->areaid]['arrparentid'] = $arrparentid;
		}

		$db->query("UPDATE ".TABLE_AREA." SET arrparentid='$arrparentid' WHERE areaid=$this->areaid");
		
		if($oldparentid)
		{
			foreach($oldarrparentids as $pid)
			{
				if($pid==0) continue;
				$oldarrchildid = $this->get_arrchildid($pid);
				$child = is_numeric($oldarrchildid) ? ",child=0" : ",child=1"; 
				$db->query("UPDATE ".TABLE_AREA." SET arrchildid='$oldarrchildid' $child WHERE areaid=$pid");
			}
		}
		return TRUE;
	}
}
?>