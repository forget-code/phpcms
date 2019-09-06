<?php 
class actor
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'ask_actor';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function actor()
	{
		$this->__construct();
	}

	function add($info)
	{
		if(!is_array($info)) return false;
		return $this->db->insert($this->table, $info);
	}

	function edit($id, $info)
	{
		$id = intval($id);
		if(!$id || !is_array($info)) return false;
		return $this->db->update($this->table, $info, "id=$id");
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
			if($id < 1) return false;
			$this->db->query("DELETE FROM $this->table WHERE id=$id");
		}
		return true;
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

	function cache()
	{
		global $M;
		$TYPES = explode("\n", $M['member_group']);
		$array = array();
		foreach($TYPES AS $k=>$v)
		{
			$result = $this->db->query("SELECT * FROM $this->table WHERE typeid='$k'");
			while($r = $this->db->fetch_array($result))
			{
				$array[$k][] = $r;
			}
			
		}
		cache_write('actor.php', $array);
		$this->db->free_result($result);
		return $array;
	}
}
?>