<?php
class certificate
{
	var $db;
	var $table;
	var $userid = 0;
	var $userid_sql = '';
	var $pages;
	var $number;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'yp_cert';
    }

	function certificate()
	{
		$this->__construct();
	}

	function set_userid($userid)
	{
		$this->userid = intval($userid);
		$this->userid_sql = " AND $this->table.`userid`=$this->userid ";
	}
	function get($id)
	{
		$id = intval($id);
		$data = $this->db->get_one("SELECT * FROM `$this->table` WHERE `id`=$id $this->userid_sql");
		return $data;
	}
	function get_companyinfo($field = '*', $userid)
	{
		$userid = intval($userid);
		$data = $this->db->get_one("SELECT $field FROM `".DB_PRE."member_company` WHERE `userid`='$userid' $this->userid_sql");
		return $data;
	}
	
	function add($info)
	{
		$this->db->insert($this->table, $info);
		$id = $this->db->insert_id();
		return $id;
	}

	function edit($id, $info)
	{
		$this->db->update($this->table, $info,"id='$id' $this->userid_sql");
		return true;
	}

	function listinfo($where = '', $order = '`listorder` DESC,`id` DESC', $page = 1, $pagesize = 30)
	{
		if($where) $where = " WHERE $where $this->userid_sql";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
        $number = cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
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
			$this->db->query("DELETE FROM `$this->table` WHERE `id`='$id'");
		}
		return true;
	}

	function status($id, $status)
	{
		if(!$id) return false;
		$status = intval($status);
		$ids = implodeids($id);
		$this->db->query("UPDATE `$this->table` SET `status`=$status WHERE `id` IN($ids) $this->userid_sql");
		return true;
	}
}
?>