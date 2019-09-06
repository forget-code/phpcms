<?php
class announce
{
	var $db;
	var $table;
	var $pages;
	var $author;

	function __construct()
	{
		global $db,$_username;
		$this->db = &$db;
		$this->table = DB_PRE.'announce';
		$this->author = $_username;
	}

	function announce()
	{
		$this->__construct();
	}

	function listinfo($page,$pagesize,$condition)
	{
		$number = cache_count("SELECT count(*) AS `count` FROM $this->table $condition");
		$this->pages = pages($number, $page, $pagesize);
		$offset = $page ? ($page-1)*$pagesize : 0;
		$announce = array();
		$sql = $this->db->query("select * from $this->table $condition ORDER by addtime DESC LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($sql))
		{
			$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
			if($r['todate'] == '0000-00-00')
				$r['todate'] = "不限";
			$announce[] = $r;
		}
		$this->db->free_result($sql);
		return $announce;
	}

	function approval($announceid,$passed)
	{
		$announceids=is_array($announceid) ? implode(',',$announceid) : $announceid;
		return $this->db->query("UPDATE $this->table SET passed=$passed WHERE announceid IN ($announceids)");
	}

	function add($announce)
	{
		$announce['username'] = $this->author;
		$announce['addtime'] = time();
		return $this->db->insert($this->table, $announce);
	}

	function delete($aid)
	{
		$aids=is_array($aid) ? implode(',',$aid) : $aid;
		return $this->db->query("DELETE FROM $this->table WHERE announceid IN ($aids)");
	}

	function edit($annouc,$where)
	{
		$annouc['addtime'] = time();
		return $this->db->update($this->table, $annouc,$where);
	}

	function getone($aid)
	{
		$announ = $this->db->get_one("SELECT * FROM  $this->table WHERE announceid='$aid'");
		return $announ;
	}

	function show($sql)
	{
		$announ = $this->db->get_one("SELECT * FROM ".DB_PRE."announce $sql ORDER BY addtime DESC");
		return $announ;
	}

	function update($aid)
	{
		return $this->db->query("UPDATE ".DB_PRE."announce SET hits=hits+1 WHERE announceid=$aid");
	}

	function error()
	{
		global $LANG;
		return $LANG[$this->errorno];
	}

}
?>