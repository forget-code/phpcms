<?php
class area
{
	var $db;
	var $table;
	var $areas = array();

	function __construct()
	{
		global $db, $AREA;
		$this->db = &$db;
		$this->areas = $AREA;
		$this->table = DB_PRE.'area';
	}

	function area()
	{
		$this->__construct();
	}

	function get($areaid, $fields = '*')
	{
		$areaid = intval($areaid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `areaid`=$areaid");
	}

	function add($area)
	{
		if(!is_array($area)) return FALSE;
        $this->db->insert($this->table, $area);
		$areaid = $this->db->insert_id();
		if($area['parentid'])
		{
			$area['arrparentid'] = $this->areas[$area['parentid']]['arrparentid'].','.$area['parentid'];
			$parentids = explode(',', $area['arrparentid']);
			foreach($parentids as $parentid)
			{
				if($parentid)
				{
					$arrchildid = $this->areas[$parentid]['arrchildid'].','.$areaid;
					$this->db->query("UPDATE $this->table SET child=1,arrchildid='$arrchildid' WHERE areaid='$parentid'");
				}
			}
		}
		else
		{
			$area['arrparentid'] = '0';
		}
		$arrparentid = $area['arrparentid'];
		$this->db->query("UPDATE $this->table SET arrchildid='$areaid',listorder=$areaid,arrparentid='$arrparentid' WHERE areaid=$areaid");
        $this->cache();
		return TRUE;
	}

	function edit($areaid, $area)
	{
		$parentid = $area['parentid'];
        $oldparentid = $this->areas[$areaid]['parentid'];
		if($parentid != $oldparentid)
		{
			$this->move($areaid, $parentid, $oldparentid);
		}
		$this->db->update($this->table, $area, "areaid=$areaid");
        $this->cache();
		return TRUE;
	}

	function delete($areaid)
	{
		if(!array_key_exists($areaid, $this->areas)) return FALSE;
        $arrparentid = $this->areas[$areaid]['arrparentid'];
        $arrchildid = $this->areas[$areaid]['arrchildid'];
		$this->db->query("DELETE FROM $this->table WHERE areaid IN ($arrchildid)");
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
			    $child = is_numeric($arrchildid) ? 0 : 1;
			    $this->db->query("UPDATE $this->table SET arrchildid='$arrchildid',child=$child WHERE areaid='$id'");
			}
		}
        $this->cache();
		return TRUE;
	}

	function cache()
	{
		@set_time_limit(600);
        cache_area();
        cache_common();
	}

	function listorder($listorder)
	{
	    if(!is_array($listorder)) return FALSE;
		foreach($listorder as $areaid=>$value)
		{
			$value = intval($value);
			$this->db->query("UPDATE ".$this->table." SET listorder=$value WHERE areaid=$areaid");
		}
        $this->cache();
		return TRUE;
	}

	function listinfo($parentid = -1)
	{
		$areas = array();
		$where = $parentid > -1 ? " AND parentid='$parentid'" : '';
		$result = $this->db->query("SELECT `areaid` FROM $this->table WHERE 1 $where ORDER BY `listorder`,`areaid`");
		while($r = $this->db->fetch_array($result))
		{
			$areas[$r['areaid']] = $this->get($r['areaid']);
		}
		$this->db->free_result($result);
		return $areas;
	}

	function repair()
	{
		@set_time_limit(600);
		if(is_array($this->areas))
		{
			foreach($this->areas as $areaid => $area)
			{
				$arrparentid = $this->get_arrparentid($areaid);
				$arrchildid = $this->get_arrchildid($areaid);
				$child = is_numeric($arrchildid) ? 0 : 1;
		        $this->db->query("UPDATE `$this->table` SET `arrparentid`='$arrparentid',`arrchildid`='$arrchildid',`child`='$child' WHERE `areaid`=$areaid");
			}
			$this->cache();
		}
        return TRUE;
	}

	function get_arrparentid($areaid, $arrparentid = '', $n = 1)
	{
		if($n > 6 || !is_array($this->areas) || !isset($this->areas[$areaid])) return false;
		$parentid = $this->areas[$areaid]['parentid'];
		$arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		if($parentid)
		{
			$arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
		}
		else
		{
			$this->areas[$areaid]['arrparentid'] = $arrparentid;
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
					if(in_array($areaid, $arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}


	function move($areaid, $parentid, $oldparentid)
	{
		$arrchildid = $this->areas[$areaid]['arrchildid'];
		$oldarrparentid = $this->areas[$areaid]['arrparentid'];
		$child = $this->areas[$areaid]['child'];
		$oldarrparentids = explode(',', $this->areas[$areaid]['arrparentid']);
		$arrchildids = explode(',', $this->areas[$areaid]['arrchildid']);
		if(in_array($parentid, $arrchildids)) return FALSE;
		$this->areas[$areaid]['parentid'] = $parentid;
		if($child)
		{
			foreach($arrchildids as $cid)
			{
				if($cid==$areaid) continue;
				$newarrparentid = $this->get_arrparentid($cid);
				$this->areas[$cid]['arrparentid'] = $newarrparentid;
				$this->db->query("UPDATE `$this->table` SET `arrparentid`='$newarrparentid' WHERE `areaid`='$cid'");
			}
		}
		if($parentid)
		{
			$arrparentid = $this->areas[$parentid]['arrparentid'].",".$parentid;
			$this->areas[$areaid]['arrparentid'] = $arrparentid;
			$arrparentids = explode(",", $arrparentid);
			foreach($arrparentids as $pid)
			{
				if($pid == 0) continue;
				$newarrchildid = $this->get_arrchildid($pid);
				$this->db->query("UPDATE `$this->table` SET `arrchildid`='$newarrchildid',`child`=1 WHERE `areaid`=$pid");
			}
		}
		else
		{
			$arrparentid = 0;
			$this->areas[$areaid]['arrparentid'] = $arrparentid;
		}
		$this->db->query("UPDATE `$this->table` SET `arrparentid`='$arrparentid' WHERE `areaid`=$areaid");
		if($oldparentid)
		{
			foreach($oldarrparentids as $pid)
			{
				if($pid==0) continue;
				$oldarrchildid = $this->get_arrchildid($pid);
				$child = is_numeric($oldarrchildid) ? 0 : 1;
				$this->db->query("UPDATE `$this->table` SET `arrchildid`='$oldarrchildid',child=$child WHERE `areaid`=$pid");
			}
		}
		return TRUE;
	}
}
?>