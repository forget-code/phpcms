<?php 
class role
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'role';
		$this->table_admin_role = DB_PRE.'admin_role';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function role()
	{
		$this->__construct();
	}

	function get($roleid)
	{
		$roleid = intval($roleid);
		if($roleid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE roleid=$roleid");
	}

	function add($role)
	{
		if(!is_array($role) || empty($role['name'])) return false;
		return $this->db->insert($this->table, $role);
	}

	function edit($roleid, $role)
	{
		if(!$roleid || !is_array($role) || empty($role['name'])) return false;
		return $this->db->update($this->table, $role, "roleid=$roleid");
	}

	function delete($roleid)
	{
		$roleid = intval($roleid);
		if($roleid < 1) return false;
		return $this->db->query("DELETE FROM $this->table WHERE roleid=$roleid");
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) AS count FROM $this->table $where");
        $number = $r['count'];
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

	function count($roleid)
	{
		$roleid = intval($roleid);
		return cache_count("SELECT COUNT(*) AS `count` FROM `$this->table_admin_role` WHERE `roleid`=$roleid");
	}

	function cache($where = '', $order = 'listorder,roleid')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['roleid']] = $r['name'];
		}
		cache_write('role.php', $array);
		return $array;
	}

	function disable($roleid, $disabled)
	{
		$roleid = intval($roleid);
		if($roleid < 1) return false;
		return $this->db->query("UPDATE $this->table SET disabled=$disabled WHERE roleid=$roleid");
	}
}
?>