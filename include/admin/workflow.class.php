<?php
class workflow
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'workflow';
		$this->table_process = DB_PRE.'process';
		$this->table_process_status = DB_PRE.'process_status';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function workflow()
	{
		$this->__construct();
	}

	function get($workflowid)
	{
		$workflowid = intval($workflowid);
		return $this->db->get_one("SELECT * FROM `$this->table` WHERE `workflowid`=$workflowid");
	}

	function checkname($name)
	{
		if(empty($name)) return false;
		$name = trim($name);
		return $this->db->get_one("SELECT * FROM `$this->table` WHERE name='$name'");
	}

	function add($info)
	{
		if(!is_array($info) || empty($info['name'])) return false;
		$this->db->insert($this->table, $info);
		return $this->db->insert_id();
	}

	function edit($workflowid, $info)
	{
		if(!$workflowid || !is_array($info) || empty($info['name'])) return false;
		return $this->db->update($this->table, $info, "workflowid=$workflowid");
	}

	function delete($workflowid)
	{
		global $priv_role;
		$workflowid = intval($workflowid);
		$this->db->query("DELETE FROM `$this->table` WHERE `workflowid`=$workflowid");
		$this->db->query("DELETE FROM `$this->table_process` WHERE `workflowid`=$workflowid");
        $workflowids = $this->db->get_one("SELECT `processid` FROM `$this->table_process` WHERE `workflowid`=$workflowid");
        $workflowids = implode(',',$workflowids);
		$this->db->query("DELETE FROM `$this->table_process_status` WHERE `processid` IN($workflowids)");
		$priv_role->delete('processid');
		return true;
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

	function cache($where = '', $order = 'workflowid')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['workflowid']] = $r['name'];
		}
		cache_write('workflow.php', $array);
		return $array;
	}
}
?>