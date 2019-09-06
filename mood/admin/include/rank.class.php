<?php 
class rank
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'mood';
		$this->table_data = DB_PRE.'mood_data';
		$this->table_content = DB_PRE.'content';
    }

	function rank()
	{
		$this->__construct();
	}

	function show($moodid = 1)
	{
		$moodid = intval($moodid);
		return $this->db->get_one("SELECT * FROM $this->table WHERE moodid=$moodid");
	}
	function get()
	{
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}

	function listinfo($moodid = 1, $page = 1, $pagesize = 50, $where = '')
	{
		
		$array = array();
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM $this->table_content c,$this->table_data d WHERE c.contentid=d.contentid AND d.moodid='$moodid' $where");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table_content c,$this->table_data d WHERE c.contentid=d.contentid AND d.moodid='$moodid' $where ORDER BY d.total DESC");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}
}
?>