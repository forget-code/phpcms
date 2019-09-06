<?php
class collect
{
	var $db;
	var $table;
	var $pages;
	var $userid_sql = '';
	var $number;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'yp_collect';
    }

	function collect()
	{
		$this->__construct();
	}

	function set_userid($userid)
	{
		$this->userid = intval($userid);
		$this->userid_sql = " AND $this->table.`userid`=$this->userid ";
	}

	function add($userid,$title,$url)
	{
		global $_userid;
		$userid = intval($userid);
		$title = strip_tags($title);
		$url = strip_tags($url);
		$r = $this->db->get_one("SELECT `cid` FROM `$this->table` WHERE `vid`='$_userid' AND `url`='$url'");
		if($r) return false;
		$this->db->query("INSERT INTO `$this->table` (`userid`,`vid`,`title`,`url`,`addtime`) VALUES ('$userid','$_userid','$title','$url','".TIME."')");
	}
	function listinfo($where = '', $order = '`cid` DESC', $page = 1, $pagesize = 30)
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
	
	function stats($where = '', $order = '`cid` DESC', $page = 1, $pagesize = 30)
	{
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$number = cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
	    $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT *,count(userid) AS number FROM `$this->table` $where $order $limit");
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
			$this->db->query("DELETE FROM `$this->table` WHERE `cid`='$id' $this->userid_sql");
		}
		return true;
	}

	function get_companyinfo($field = '*', $userid)
	{
		$userid = intval($userid);
		$data = $this->db->get_one("SELECT $field FROM `".DB_PRE."member_company` WHERE `userid`='$userid' $this->userid_sql");
		return $data;
	}
}
?>