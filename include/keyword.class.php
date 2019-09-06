<?php
class keyword
{
	var $db;
	var $pages;
	var $number;
	var $table;
	var $table_tag;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'keyword';
		$this->table_tag = DB_PRE.'content_tag';
    }

	function keyword()
	{
		$this->__construct();
	}


	function get($tag)
	{
		return $this->db->get_one("SELECT * FROM $this->table WHERE `tag`='$tag'");
	}

	function add($tag)
	{
		if(!is_array($tag) || empty($tag['tag'])) return false;
		if($this->checktag($tag['tag'])) return false;
		$this->db->insert($this->table, $tag);
		cache_keyword();
		return true;
	}

	function edit($tagid, $tag)
	{
		if(!$tagid || !is_array($tag) || empty($tag['tag'])) return false;
		if($this->checktag($tag['tag'], $tagid)) return false;
		$this->db->update($this->table, $tag, "tagid=$tagid");
		cache_keyword();
		return true;
	}

	function checktag($tag, $tagid = 0)
	{
		if($tagid)
		{
			$tagid = intval($tagid);
			return $this->db->get_one("SELECT tagid FROM $this->table WHERE `tag`='$tag' AND tagid!=$tagid");
		}
		return $this->db->get_one("SELECT tagid FROM $this->table WHERE `tag`='$tag'");
	}

	function delete($tagid)
	{
		$tagid = intval($tagid);
		if($tagid < 1) return false;
		$this->db->query("DELETE FROM $this->table WHERE tagid=$tagid");
		cache_keyword();
		return true;
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) AS number FROM $this->table $where");
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

	function listorder($listorder)
	{
	    if(!is_array($listorder)) return FALSE;
		foreach($listorder as $tagid=>$value)
		{
			$value = intval($value);
			$this->db->query("UPDATE ".$this->table." SET listorder=$value WHERE tagid=$tagid");
		}
		cache_keyword();
		return true;
	}

	function hits($tag)
	{
		return $this->db->query("UPDATE `$this->table` SET `hits`=`hits`+1,`lasthittime`=".TIME." WHERE `tag`='$tag'");
	}
}
?>