<?php 
class status
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'status';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function status()
	{
		$this->__construct();
	}

	function get($status)
	{
		$status = intval($status);
		return $this->db->get_one("SELECT * FROM $this->table WHERE status=$status");
	}

	function add($info)
	{
		if(!is_array($info) || empty($info['name'])) return false;
		return $this->db->insert($this->table, $info);
	}

	function edit($status, $info)
	{
		if(!$status || !is_array($info) || empty($info['name'])) return false;
		return $this->db->update($this->table, $info, "status=$status");
	}

	function delete($status)
	{
		$status = intval($status);
		return $this->db->query("DELETE FROM $this->table WHERE status=$status");
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

	function cache($where = '', $order = 'status')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['status']] = $r['name'];
		}
		cache_write('status.php', $array);
		return $array;
	}
}
?>