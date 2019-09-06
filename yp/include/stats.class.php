<?php
class stats
{
	var $db;
	var $table;
	var $userid = 0;
	var $userid_sql = '';
	var $pages;
	var $number;
	var $table_company;
	var $table_count;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'yp_stats';
		$this->table_company = DB_PRE.'member_company';
		$this->table_count = DB_PRE.'yp_count';
    }

	function stats()
	{
		$this->__construct();
	}

	function set_userid($userid)
	{
		$this->userid = intval($userid);
		$this->userid_sql = " AND $this->table.`userid`=$this->userid ";
	}
	function get($userid,$vid)
	{
		$userid = intval($userid);
		$vid = intval($vid);
		$data = $this->db->get_one("SELECT * FROM `$this->table` WHERE `userid`='$userid' AND `vid`='$vid'");
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
		$this->hits($this->userid);
		return $id;
	}

	function update($sid)
	{
		$this->db->query("UPDATE `$this->table` SET `updatetime`=".TIME.",`hits`=hits+1,`ip`='".IP."' WHERE `sid`='$sid'");
		$this->hits($this->userid);
		return true;
	}

	function listinfo($where = '', $order = '`sid` DESC', $page = 1, $pagesize = 30, $more_table = 0)
	{
		if($where) $where = " WHERE $where $this->userid_sql";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		if($more_table)
		{
			$number = cache_count("SELECT count(sid) AS `count` FROM `$this->table` a,`$this->table_company` c $where");
		}
		else
		{
			$number = cache_count("SELECT count(sid) AS `count` FROM `$this->table` $where");
		}
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		if($more_table)
		{
			$result = $this->db->query("SELECT a.*,c.companyname,sitedomain FROM `$this->table` a,`$this->table_company` c $where $order $limit");
		}
		else
		{
			$result = $this->db->query("SELECT * FROM `$this->table` $where $order $limit");
		}
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
			$this->db->query("DELETE FROM `$this->table` WHERE `sid`='$id'");
		}
		return true;
	}

	function get_total($where)
	{
		$r = $this->db->get_one("SELECT sum(hits) AS number FROM `$this->table` WHERE $where");
		return $r['number'];
	}

	function hits($userid)
	{
		$userid = intval($userid);
		$r = $this->db->get_one("SELECT * FROM `".DB_PRE."yp_count` WHERE `id`=$userid AND `model`='company'");
		if(!$r) return false;
		$hits = $r['hits'] + 1;
		$hits_day = (date('Ymd', $r['hits_time']) == date('Ymd', TIME)) ? ($r['hits_day'] + 1) : 1;
		$hits_week = (date('YW', $r['hits_time']) == date('YW', TIME)) ? ($r['hits_week'] + 1) : 1;
		$hits_month = (date('Ym', $r['hits_time']) == date('Ym', TIME)) ? ($r['hits_month'] + 1) : 1;
        return $this->db->query("UPDATE `$this->table_count` SET `hits`=$hits,`hits_day`=$hits_day,`hits_week`=$hits_week,`hits_month`=$hits_month,`hits_time`=".TIME." WHERE `id`=$userid AND `model`='company'");
	}
}
?>