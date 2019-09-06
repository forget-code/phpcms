<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class special
{
	var $keyid = 0;
	var $specialid = 0;
	var $special = array();

    function special($keyid, $specialid = 0)
    {
        $this->keyid = intval($keyid);
        $this->specialid = intval($specialid);
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
	}

	function add($special)
	{
		global $db;
		if(!is_array($special)) return FALSE;
		$sql1 = $sql2 = $s = '';
		foreach($special as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ',';
		}
		$db->query("INSERT INTO ".TABLE_SPECIAL." ($sql1) VALUES($sql2)");
		if(!$db->affected_rows()) return FALSE;
        $this->specialid = $db->insert_id();
		$this->special = $special;
		$linkurl = special_showurl('url', $this->specialid, $special['addtime'], $special['prefix']);
		$db->query("UPDATE ".TABLE_SPECIAL." SET listorder=$this->specialid,linkurl='$linkurl' WHERE specialid=$this->specialid");
		return $this->specialid;
	}

	function edit($special)
	{
		global $db;
		if(!is_array($special)) return FALSE;
		$special['linkurl'] = special_showurl('url', $this->specialid, $special['addtime'], $special['prefix']);
		$sql = $s = '';
		foreach($special as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$this->special = $special;
		$db->query("UPDATE ".TABLE_SPECIAL." SET $sql WHERE specialid=$this->specialid");
        return $db->affected_rows();
	}

	function delete()
	{
		global $db;
		$db->query("DELETE FROM ".TABLE_SPECIAL." WHERE specialid=$this->specialid");
		return $db->affected_rows();
	}

	function disable($value)
	{
		global $db;
		$db->query("UPDATE ".TABLE_SPECIAL." SET disabled='$value' WHERE specialid=$this->specialid");
        return $db->affected_rows();
	}

	function elite($value)
	{
		global $db;
		$value = intval($value);
		if($value > 5 && $value < 0) return FALSE;
		$db->query("UPDATE ".TABLE_SPECIAL." SET elite=$value WHERE specialid=$this->specialid");
        return $db->affected_rows();
	}

	function close($value)
	{
		global $db;
		if($value != 1 && $value != 0) return FALSE;
		$db->query("UPDATE ".TABLE_SPECIAL." SET closed='$value' WHERE specialid=$this->specialid");
        return $db->affected_rows();
	}

	function get_count($sql = '')
	{
		global $db;
		if($sql) $sql = ' AND '.$sql; 
	    $r = $db->get_one("SELECT COUNT(*) AS number FROM ".TABLE_SPECIAL." WHERE keyid=$this->keyid $sql");
		return $r['number'];
	}

	function get_list($sql = '', $offset = 0, $pagesize = 0)
	{
		global $db,$CHANNEL;
		if($sql) $sql = ' AND '.$sql; 
		$limit = $pagesize ? "LIMIT $offset,$pagesize" : '';
		$specials = array();
		$result = $db->query("SELECT * FROM ".TABLE_SPECIAL." WHERE keyid=$this->keyid $sql ORDER BY listorder DESC,specialid DESC $limit");
		while($r = $db->fetch_array($result))
		{
			$specials[$r['specialid']] = $r;
		}
		$db->free_result($result);
		return $specials;
	}

	function get_info($specialid = 0)
	{
		global $db;
		if($specialid) $this->specialid = $specialid;
		$data = $db->get_one("SELECT * FROM ".TABLE_SPECIAL." WHERE specialid=$this->specialid");
		if(!$data) return FALSE;
		if($data['parentid'] > 0) return $data;
		$subspecials = array();
		$result = $db->query("SELECT * FROM ".TABLE_SPECIAL." WHERE parentid=$this->specialid ORDER BY specialid");
		while($r = $db->fetch_array($result))
		{
			$r['linkurl'] = linkurl($r['linkurl']);
			$subspecials[$r['specialid']] = $r;
		}
		$data['subspecial'] = $subspecials;
		return $data;
	}

	function add_subspecial($subspecialnames)
	{
		global $db,$PHP_TIME;
		if(!is_array($subspecialnames)) return FALSE;
		$prefix = $this->special['prefix'];
		$specialids = array();
		foreach($subspecialnames as $specialname)
		{
			$db->query("INSERT INTO ".TABLE_SPECIAL."(keyid,parentid,specialname,prefix,addtime) VALUES('$this->keyid','$this->specialid','$specialname','$prefix','$PHP_TIME')");
			$specialid = $db->insert_id();
			$specialids[] = $specialid;
		    $linkurl = special_showurl('url', $specialid, $PHP_TIME, $prefix);
		    $db->query("UPDATE ".TABLE_SPECIAL." SET linkurl='$linkurl' WHERE specialid=$specialid");
		}
        $this->update_arrchildid();
        return $specialids;
	}

	function update_subspecial($subspecialnames, $newsubspecialnames = array(), $delete = array())
	{
		global $db;
        foreach($delete as $specialid=>$v)
        {
            $db->query("DELETE FROM ".TABLE_SPECIAL." WHERE specialid=$specialid");
			unset($subspecialnames[$specialid]);
        }
		foreach($subspecialnames as $specialid=>$specialname)
		{
			$db->query("UPDATE ".TABLE_SPECIAL." SET specialname='$specialname' WHERE specialid=$specialid");
		}
		if($newsubspecialnames) $this->add_subspecial($newsubspecialnames);
        $this->update_arrchildid();
		return TRUE;
	}

	function update_arrchildid($specialid = 0)
	{
		global $db;
		if($specialid) $this->specialid = $specialid;
		$specialids = array();
		$result = $db->query("SELECT specialid FROM ".TABLE_SPECIAL." WHERE parentid=$this->specialid");
		while($r = $db->fetch_array($result))
		{
			$specialids[] = $r['specialid'];
		}
		$arrchildid = implode(',', $specialids);
		$db->query("UPDATE ".TABLE_SPECIAL." SET arrchildid='$arrchildid' WHERE specialid=$this->specialid");
	}

	function update_linkurl()
	{
		global $db;
		$result = $db->query("SELECT specialid,addtime,prefix FROM ".TABLE_SPECIAL." WHERE keyid='$this->keyid' AND closed=0 AND disabled=0");
		while($r = $db->fetch_array($result))
		{
			$linkurl = special_showurl('url', $r['specialid'], $r['addtime'], $r['prefix']);
			$db->query("UPDATE ".TABLE_SPECIAL." SET linkurl='$linkurl' WHERE specialid=".$r['specialid']);
		}
	}

	function setting($setting)
	{
		global $db;
		if(!is_array($setting)) return FALSE;
		$setting = addslashes(serialize(new_stripslashes($setting)));
		$db->query("UPDATE ".TABLE_SPECIAL." SET setting='$setting' WHERE specialid=$this->specialid");
		return TRUE;
	}

	function listorder($listorder)
	{
		global $db;
		if(!is_array($listorder)) return FALSE;
		foreach($listorder as $specialid=>$value)
		{
			$value = intval($value);
			$db->query("UPDATE ".TABLE_SPECIAL." SET listorder=$value WHERE specialid=$specialid");
		}
		return TRUE;
	}
}
?>