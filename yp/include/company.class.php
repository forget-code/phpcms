<?php 
class company
{
	var $db;
	var $pages;
	var $number;
	var $table;
	var $table_member;
	var $table_count;
	var $table_member_cache;

	function __construct()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'member_company';
		$this->table_member = DB_PRE.'member';
		$this->table_member_cache = DB_PRE.'member_cache';
		$this->table_count = DB_PRE.'yp_count';
	}

	function company()
	{
		$this->__construct();
	}

	function get($userid)
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE userid=$userid");
	}

	function edit($modelid, $model)
	{
		if(!$modelid || !is_array($model) || empty($model['name']) || empty($model['tablename'])) return false;
		$this->db->update($this->table, $model, "modelid=$modelid");
		$this->cache();
		$this->cache_field($modelid);
		return true;
	}

	function delete($id)
	{
		if(is_array($id))
		{
			array_map(array(&$this, 'delete'), $id);
		}
		else
		{
			$id = intval($id);
			$this->db->query("DELETE FROM `$this->table` WHERE `userid`='$id' $this->userid_sql");
		}
		return true;
	}
	
	function elite($id, $status = 0)
	{
		$status = intval($status);
		if(is_array($id))
		{
			$id = implodeids($id);
			$this->db->query("UPDATE `$this->table` SET `elite`='$status' WHERE `userid` IN ($id) $this->userid_sql");
		}
		else
		{
			$this->db->query("UPDATE `$this->table` SET `elite`='$status' WHERE `id`='$id' $this->userid_sql");
		}
		return true;
	}
	
	function status($id, $status = 0)
	{
		$status = intval($status);
		if(is_array($id))
		{
			$id = implodeids($id);
			$this->db->query("UPDATE `$this->table` SET `status`='$status' WHERE `userid` IN ($id) $this->userid_sql");
		}
		else
		{
			$this->db->query("UPDATE `$this->table` SET `status`='$status' WHERE `id`='$id' $this->userid_sql");
		}
		return true;
	}

	function listinfo($where = '', $order = 'a.userid DESC', $page = 1, $pagesize = 20, $moreinfo = 0)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$limit = " LIMIT $offset, $pagesize";
		$moretable = '';
		if($moreinfo) $moretable = ','.DB_PRE.'member_info i';
		$r = $this->db->get_one("SELECT count(*) AS number FROM $this->table a,$this->table_member_cache c $moretable $where");
		$number = $r['number'];
		$this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table a,$this->table_member_cache c $moretable $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
		$this->db->free_result($result);
		return $array;
	}

	function get_yp_arrchildid($id)
	{
		$id = intval($id);
		$sql = "SELECT arrchildid FROM `".DB_PRE."category` WHERE parentid = '{$id}' AND module = 'yp'";
		return $this->db->get_one($sql);
	}

	function get_count($id)
	{
		$id = intval($id);
		return $this->db->get_one("SELECT * FROM `$this->table_count` WHERE `id`=$id AND `model`='company'");
	}
}
?>