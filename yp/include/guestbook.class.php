<?php
class guestbook
{
	var $db;
	var $table;
	var $pages;
	var $number;
	var $userid_sql = '';

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'yp_guestbook';
    }

	function guestbook()
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
		return $this->db->get_one("SELECT * FROM `$this->table` WHERE `gid`='$id' $this->userid_sql");
	}
	
	function sign($id,$style)
	{
		$id = intval($id);
		$this->db->query("UPDATE `$this->table` SET `style`='$style' WHERE `gid`='$id' $this->userid_sql");
		return true;
	}
	
	function status($id)
	{
		$id = intval($id);
		$this->db->query("UPDATE `$this->table` SET `status`=1 WHERE `gid`='$id' $this->userid_sql");
		return true;
	}

	function listinfo($where = '', $order = '`gid` DESC', $page = 1, $pagesize = 30)
	{
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
			$this->db->query("DELETE FROM `$this->table` WHERE `gid`='$id' $this->userid_sql");
		}
		return true;
	}
}
?>