<?php

if(!class_exists('group'))
{
	require_once MOD_ROOT.'include/group.class.php';
}

class group_admin extends group
{

	function group()
	{
		$this->__construct();
	}

	function get($groupid)
	{
		$groupid = intval($groupid);
		if($groupid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE groupid=$groupid");
	}

	function add($group)
	{
		if(!is_array($group) || !$this->check_name($group['name']))
		{
			return false;
		}
		return $this->db->insert($this->table, $group);
	}
	
	function check_name($name, $groupid = '')
	{
		if(strlen($name) > 20 || strlen($name) < 3)
		{
			$this->msg = 'name_not_correct';
			return false;
		}
		if($groupid)
		{
			$groupid = intval($groupid);
			$result = $this->db->get_one("SELECT groupid FROM $this->table WHERE name='$name' AND groupid!='$groupid'");
		}
		else
		{
			$result = $this->db->get_one("SELECT groupid FROM $this->table WHERE name='$name'");
			
		}
		if($result)
		{
			$this->msg = 'group_existed';
			return false;
		}
		return ture;
	}

	function edit($groupid, $group)
	{
		if(!$groupid || !is_array($group) || empty($group['name'])) return false;
		if(!$this->check_name($group['name'], $groupid)) return false;
		return $this->db->update($this->table, $group, "groupid=$groupid");
	}

	function delete($groupid)
	{
		$groupid = intval($groupid);
		if($groupid < 1) return false;
		return $this->db->query("DELETE FROM $this->table WHERE groupid=$groupid");
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) FROM $this->table $where");
        $number = $r[0];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$extends = $this->extend_group_list($r['groupid']);
			$r['extend_disable'] = $extends['disabled'] ?  $extends['disabled'] : 0 ;
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function cache($where = 'disabled=0', $order = 'groupid')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['groupid']] = $r['name'];
		}
		cache_write('member_group.php', $array);
		$this->cache_ext();
		return $array;
	}

	function cache_ext($where = 'issystem=0 AND disabled=0', $order = 'groupid')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['groupid']] = $r['name'];
		}
		cache_write('member_group_extend.php', $array);
		return $array;
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE groupid=$id");
		}
		return true;
	}

	function disable($groupid, $disabled)
	{
		$groupid = intval($groupid);
		if($groupid < 1) return false;
		$disabled = intval($disabled);
		return $this->db->query("UPDATE $this->table SET disabled=$disabled WHERE groupid=$groupid");
	}

	function msg()
	{
		global $LANG;
		return $LANG[$this->msg];
	}
}
?>