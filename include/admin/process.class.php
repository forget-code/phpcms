<?php 
class process
{
	var $db;
	var $table;
	var $priv_role;
	var $pages;
	var $number;

    function __construct($workflowid)
    {
		global $db, $priv_role;
		$this->db = &$db;
		$this->table = DB_PRE.'process';
		$this->table_process_status = DB_PRE.'process_status';
		$this->priv_role = &$priv_role;
		$this->workflowid = $workflowid;
		register_shutdown_function(array(&$this, 'cache'));
    }

	function process($workflowid)
	{
		$this->__construct($workflowid);
	}

	function get($processid, $fields = '*')
	{
		$processid = intval($processid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `processid`=$processid");
	}

	function add($info, $status = array(), $priv_roleid = array())
	{
		if(!is_array($info) || empty($info['name'])) return false;
		$info['workflowid'] = $this->workflowid;
		$this->db->insert($this->table, $info);
		$processid = $this->db->insert_id();
        $this->set_process_status($processid, $status);
		$this->priv_role->update('processid', $processid, $priv_roleid);
		return $processid;
	}

	function edit($processid, $info, $status = array(), $priv_roleid = array())
	{
		if(!$processid || !is_array($info) || empty($info['name'])) return false;
		$this->db->update($this->table, $info, "processid=$processid");
        $this->set_process_status($processid, $status);
		$this->priv_role->update('processid', $processid, $priv_roleid);
		return true;
	}

	function delete($processid)
	{
		$processid = intval($processid);
		$this->db->query("DELETE FROM `$this->table` WHERE `processid`=$processid");
		$this->db->query("DELETE FROM `$this->table_process_status` WHERE `processid`=$processid");
		$this->priv_role->delete('processid', $processid);
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

	function cache()
	{
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table WHERE workflowid=$this->workflowid ORDER BY processid");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['processid']] = $r['name'];
		}
        $this->db->free_result($result);
		cache_write('process_'.$this->workflowid.'.php', $array);
		return $array;
	}

	function set_process_status($processid, $statuss = array())
	{
		$this->db->query("DELETE FROM `$this->table_process_status` WHERE `processid`=$processid");
		if($statuss)
		{
			foreach($statuss as $status)
			{
				$this->db->query("INSERT INTO `$this->table_process_status`(`processid`, `status`) VALUES('$processid', '$status')");
			}
		}
		return true;
	}

	function get_process_status($processid)
	{
		$array = array();
		$result = $this->db->query("SELECT `status` FROM $this->table_process_status WHERE `processid`=$processid");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r['status'];
		}
        $this->db->free_result($result);
        return $array;
	}
}
?>