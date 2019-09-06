<?php
class player
{
	var $db;
	var $table;

	function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'player';
    }

	function player()
	{
		$this->__construst();
	}

	function get($playerid)
	{
		$where = "playerid='$playerid'";
		$info = $this->db->get_one("SELECT * FROM $this->table WHERE $where");
		return $info;
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM $this->table $where");
		$number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function add($info)
	{
		if(!$info['subject'] || !$info['code'])
		{
			return false;
		}
		if(!$this->checkname($info['subject']))
		{
			return false;
		}
		$playerid = $this->db->insert($this->table, $info);
		return $playerid;
	}

	function edit($playerid, $info)
	{
		$playerid = intval($playerid);
		if(!$playerid || !$info['subject'] || !$info['code'])
		{
			return false;
		}
		if(!$this->checkname($info['subject'], $playerid))
		{
			return false;
		}
		$playerid = $this->db->update($this->table, $info, "playerid='$playerid'");
		return $playerid;
	}

	function disabled($playerid, $isdisable)
	{
		$playerid = intval($playerid);
		if(!$playerid)
		{
			return false;
		}
		$arr_disable = array('disabled'=>$isdisable);
		$this->db->update($this->table, $arr_disable, "playerid='$playerid'");
		return true;
	}

	function delete($playerid)
	{
		$playerid = intval($playerid);
		if(!$playerid)
		{
			return false;
		}
		$this->db->query("DELETE FROM $this->table WHERE playerid='$playerid'");
		return true;
	}

	function checkname($playername, $playerid = '')
	{		
		$playerid = intval($playerid);
		$result = $this->db->get_one("SELECT playerid FROM $this->table WHERE subject='$playername' AND playerid!='$playerid'");
		if($result)
		{
			return false;
		}
		return true;
	}
}
?>