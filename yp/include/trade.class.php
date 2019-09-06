<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class trade
{
	var $script;
	var $tradeid;
	var $trades = array();
	var $updatecache = 1;

	function trade($script, $tradeid = 0)
	{
		global $TRADE,$CHAANEL;
        if(!$script) return FALSE;
		$this->script = $script;
		$this->tradeid = $tradeid;
		if(!isset($TRADE))
		{
			$TRADE = cache_read('trades_'.$this->script.'.php');
		}
		$this->trades = $TRADE;
		register_shutdown_function(array(&$this, '__destruct'));
	}

	function __destruct()
	{
		if($this->updatecache) cache_trades($this->script);
	}

	function add($trade, $setting = array())
	{
		global $db;
		if(!is_array($trade)) return FALSE;
		$sql1 = $sql2 = $s = '';
		foreach($trade as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ',';
		}
		$db->query("INSERT INTO ".TABLE_YP_TRADE." ($sql1) VALUES($sql2)");
		
		$this->tradeid = $db->insert_id();

		if($trade['parentid'])
		{
			$trade['arrparentid'] = $this->trades[$trade['parentid']]['arrparentid'].",".$trade['parentid'];
			$parentids = explode(',', $trade['arrparentid']);
			foreach($parentids as $parentid)
			{
				if($parentid)
				{
					$arrchildid = $this->trades[$parentid]['arrchildid'].','.$this->tradeid;
					$db->query("UPDATE ".TABLE_YP_TRADE." SET child=1,arrchildid='$arrchildid' WHERE tradeid='$parentid'");
				}
			}
		}
		else
		{
			$trade['arrparentid'] = '0';
		}

		$arrparentid = $trade['arrparentid'];
		$db->query("UPDATE ".TABLE_YP_TRADE." SET arrchildid='$this->tradeid',listorder=$this->tradeid,arrparentid='$arrparentid' WHERE tradeid=$this->tradeid");
		$this->setting($setting);
        cache_trade($this->tradeid);
		return TRUE;
	}

	function edit($trade, $setting = array())
	{
		global $db;
		$parentid = $trade['parentid'];
        $oldparentid = $this->trades[$this->tradeid]['parentid'];
		if($parentid != $oldparentid)
		{
			$this->move($parentid, $oldparentid);
		}
		$sql = $s = '';
		foreach($trade as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ',';
		}
		$db->query("UPDATE ".TABLE_YP_TRADE." SET $sql WHERE tradeid=$this->tradeid");
		$this->update_linkurl($this->tradeid);
		$this->setting($setting);
        cache_trade($this->tradeid);
		return TRUE;
	}

	function delete()
	{
		global $db,$CONFIG;
		if(!array_key_exists($this->tradeid, $this->trades)) return FALSE;
        $arrparentid = $this->trades[$this->tradeid]['arrparentid'];
        $arrchildid = $this->trades[$this->tradeid]['arrchildid'];
		$db->query("DELETE FROM ".TABLE_YP_TRADE." WHERE tradeid IN ($arrchildid)");
		$tradeids = explode(',', $arrchildid);
		foreach($tradeids as $id)
		{
            unset($this->trades[$id]);
		}
		if($arrparentid)
		{
		    $arrparentids = explode(',', $arrparentid);
			foreach($arrparentids as $id)
			{
				if($id == 0) continue;
			    $arrchildid = $this->get_arrchildid($id);
			    $child = is_numeric($arrchildid) ? ',child=0' : ',child=1';                   
			    $db->query("UPDATE ".TABLE_YP_TRADE." SET arrchildid='$arrchildid' $child WHERE tradeid='$id'");
			}
		}
        $this->tradeid = 0;
	}

	function listorder($listorder)
	{
		global $db;
	    if(!is_array($listorder)) return FALSE;
		foreach($listorder as $tradeid=>$value)
		{
			$value = intval($value);
			$db->query("UPDATE ".TABLE_YP_TRADE." SET listorder=$value WHERE tradeid=$tradeid");
		}
		return TRUE;
	}

	function disable($value)
	{
		global $db;
		cache_delete('trade_'.$this->tradeid.'.php');
		$db->query("UPDATE ".TABLE_YP_TRADE." SET disabled='$value' WHERE tradeid=$this->tradeid");
        return $db->affected_rows();
	}

	function get_list()
	{
		global $db;
		$trades = array();
		$result = $db->query("SELECT tradeid FROM ".TABLE_YP_TRADE." WHERE script='$this->script' ORDER BY listorder");
		while($r = $db->fetch_array($result))
		{
			$trades[$r['tradeid']] = $this->get_info($r['tradeid']);
		}
		$db->free_result($result);
		$this->updatecache = 0;
		return $trades;
	}

	function get_info($tradeid = 0)
	{
		global $db;
		if($tradeid) $this->tradeid = $tradeid;
		$data = $db->get_one("SELECT * FROM ".TABLE_YP_TRADE." WHERE tradeid=$this->tradeid");
		if($data['setting'])
		{
			$setting = unserialize($data['setting']);
			unset($data['setting']);
			$data = is_array($setting) ? array_merge($data, $setting) : $data;
		}
		$this->updatecache = 0;
		return $data;
	}

    function update_linkurl($tradeid)
    {
	    global $db;
		$linkurl = trade_url('url', $tradeid,$this->script);
		$db->query("UPDATE ".TABLE_YP_TRADE." SET linkurl='$linkurl' WHERE tradeid=$tradeid");
        return TRUE;
    }

	function repair()
	{
		global $db;
		if(is_array($this->trades))
		{
			foreach($this->trades as $tradeid => $trade)
			{
				if($tradeid == 0) continue;
				$this->tradeid = $tradeid;
				$arrparentid = $this->get_arrparentid($tradeid);
				$arrchildid = $this->get_arrchildid($tradeid);
				$child = is_numeric($arrchildid) ? 0 : 1;
		        $db->query("UPDATE ".TABLE_YP_TRADE." SET arrparentid='$arrparentid',arrchildid='$arrchildid',child='$child' WHERE tradeid=$tradeid");
				$this->update_linkurl($tradeid,$this->script);
		        cache_trade($tradeid);
			}
		}
        return TRUE;
	}

	function setting($setting)
	{
		global $db;
		if(!is_array($setting)) return FALSE;
		$setting = addslashes(serialize(new_stripslashes($setting)));
		$db->query("UPDATE ".TABLE_YP_TRADE." SET setting='$setting' WHERE tradeid=$this->tradeid");
		return TRUE;
	}

	function get_arrparentid($tradeid, $arrparentid='')
	{
		if(is_array($this->trades))
		{
			$parentid = $this->trades[$tradeid]['parentid'];
			$arrparentid = $arrparentid ? $parentid.",".$arrparentid : $parentid;
			if($parentid)
			{
				$arrparentid = $this->get_arrparentid($parentid,$arrparentid);
			}
			else
			{
				$this->trades[$tradeid]['arrparentid'] = $arrparentid;
			}
		}
		return $arrparentid;
	}

	function get_arrchildid($tradeid)
	{
		$arrchildid = $tradeid;
		if(is_array($this->trades))
		{
			foreach($this->trades as $id => $trade)
			{
				if($trade['parentid'] && $id != $tradeid)
				{
					$arrparentids = explode(',', $trade['arrparentid']);
					if(in_array($tradeid,$arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}


	function move($parentid, $oldparentid)
	{
		global $db;
		$arrchildid = $this->trades[$this->tradeid]['arrchildid'];
		$oldarrparentid = $this->trades[$this->tradeid]['arrparentid'];
		$child = $this->trades[$this->tradeid]['child'];
		$oldarrparentids = explode(",", $this->trades[$this->tradeid]['arrparentid']);
		$arrchildids = explode(",", $this->trades[$this->tradeid]['arrchildid']);
		if(in_array($parentid,$arrchildids)) return FALSE;
		
		$this->trades[$this->tradeid]['parentid'] = $parentid;

		if($child)
		{
			foreach($arrchildids as $cid)
			{
				if($cid==$this->tradeid) continue;
				$newarrparentid = $this->get_arrparentid($cid);
				$this->trades[$cid]['arrparentid'] = $newarrparentid;
				$db->query("UPDATE ".TABLE_YP_TRADE." SET arrparentid='$newarrparentid' WHERE tradeid='$cid'");
			}
		}
		
		if($parentid)
		{
			$arrparentid = $this->trades[$parentid]['arrparentid'].",".$parentid;
			$this->trades[$this->tradeid]['arrparentid'] = $arrparentid;
			$arrparentids = explode(",", $arrparentid);
			foreach($arrparentids as $pid)
			{
				if($pid==0) continue;
				$newarrchildid = $this->get_arrchildid($pid);
				$db->query("UPDATE ".TABLE_YP_TRADE." SET arrchildid='$newarrchildid',child=1 WHERE tradeid=$pid");
			}
		}
		else
		{
			$arrparentid = 0;
			$this->trades[$this->tradeid]['arrparentid'] = $arrparentid;
		}

		$db->query("UPDATE ".TABLE_YP_TRADE." SET arrparentid='$arrparentid' WHERE tradeid=$this->tradeid");
		
		if($oldparentid)
		{
			foreach($oldarrparentids as $pid)
			{
				if($pid==0) continue;
				$oldarrchildid = $this->get_arrchildid($pid);
				$child = is_numeric($oldarrchildid) ? ",child=0" : ",child=1"; 
				$db->query("UPDATE ".TABLE_YP_TRADE." SET arrchildid='$oldarrchildid' $child WHERE tradeid=$pid");
			}
		}
		return TRUE;
	}
}
?>