<?php 
class author
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'author';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function author()
	{
		$this->__construct();
	}

	function get($authorid)
	{
		$authorid = intval($authorid);
		if($authorid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE authorid=$authorid");
	}

	function add($author)
	{
		if(!is_array($author) || empty($author['name'])) return false;
		if($this->checkusername($author['name'])) return false;
		return $this->db->insert($this->table, $author);
	}

	function edit($authorid, $author)
	{
		if(!$authorid || !is_array($author) || empty($author['name'])) return false;
		if($this->checkusername($author['anme'], $authorid)) return false;
		return $this->db->update($this->table, $author, "authorid=$authorid");
	}

	function checkusername($name, $authorid = 0)
	{
		if ($authorid)
		{
			$authorid = intval($authorid);
			return $this->db->get_one("SELECT username FROM $this->table WHERE name='$name' AND authorid!=$authorid");
		}
		return $this->db->get_one("SELECT username FROM $this->table WHERE name='$name'");
	}
	
	function delete($authorid)
	{
		$authorid = intval($authorid);
		if($authorid < 1) return false;
		return $this->db->query("DELETE FROM $this->table WHERE authorid=$authorid");
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

	function cache($where = '', $order = 'listorder,authorid')
	{
		return cache_author();
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE authorid=$id");
		}
		return true;
	}

	function disable($authorid, $disabled)
	{
		$authorid = intval($authorid);
		if($authorid < 1) return false;
		return $this->db->query("UPDATE $this->table SET disabled=$disabled WHERE authorid=$authorid");
	}
}
?>