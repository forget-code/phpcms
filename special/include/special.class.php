<?php
class special
{
	var $db;
	var $pages;
	var $number;
	var $table;
    var $contentpages;

    function __construct()
    {
		global $db,$M;
		$this->db = &$db;
		$this->table = DB_PRE.'special';
        $this->table_content = DB_PRE.'content';
        $this->table_special_content = DB_PRE.'special_content';
		$this->M = $M;
		$this->url = load('url.class.php', 'special', 'include');
    }

	function special()
	{
		$this->__construct();
	}

	function get($specialid)
	{
		$specialid = intval($specialid);
		if($specialid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE specialid=$specialid");
	}

	function add($info)
	{
		global $_userid,$_username;
		if(!is_array($info) || empty($info['title'])) return false;
        $info['createtime'] = TIME;
        $info['userid'] = $_userid;
        $info['username'] = $_username;
		$this->db->insert($this->table, $info);
		$specialid = $this->db->insert_id();
		$url = $this->M['url'].$this->url->show($specialid, $info['filename'], $info['typeid']);
		$this->db->query("UPDATE `$this->table` SET `url`='$url' WHERE `specialid`=$specialid");
		return $specialid;
	}

	function edit($specialid, $info)
	{
		if(!$specialid || !is_array($info) || empty($info['title'])) return false;
		$info['url'] = $this->M['url'].$this->url->show($specialid, $info['filename'], $info['typeid']);
		return $this->db->update($this->table, $info, "specialid=$specialid");
	}

	function delete($specialid)
	{
		$specialid = intval($specialid);
		return $this->db->query("DELETE FROM $this->table WHERE specialid=$specialid");
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

    function select_content($contentid, $specialid)
    {
        $specialid = intval($specialid);
        if(is_array($contentid))
		{
			$contentid = array_map('intval', $contentid);
			foreach($contentid AS $id)
			{
				$this->db->query("INSERT INTO `$this->table_special_content` (`specialid`, `contentid`) VALUES($specialid, $id)");
			}
		}
		else
		{
			$this->db->query("INSERT INTO `$this->table_special_content` (`specialid`, `contentid`) VALUES($specialid, $contentid)");
		}
        return true;
    }

    function list_content($specialid, $page = 1, $pagesize = 50)
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM `$this->table_special_content` AS a ,`$this->table_content` AS b WHERE a.contentid = b.contentid AND specialid = $specialid");
        $number = $r['number'];
        $this->contentpages = pages($number, $page, $pagesize);
		return $this->db->select("SELECT * FROM `$this->table_special_content` AS a ,`$this->table_content` AS b WHERE a.contentid=b.contentid AND a.specialid=$specialid ORDER BY a.contentid $limit");
	}

    function del_content($specialid, $contentid)
	{
		$specialid = intval($specialid);
        if(is_array($contentid)) $contentid = array_map('intval', $contentid);
        $contentids = implodeids($contentid);
		return $this->db->query("DELETE FROM `$this->table_special_content` WHERE specialid=$specialid AND `contentid` IN($contentids)");
	}

	function exists_content($specialid, $contentid)
	{
		$specialid = intval($specialid);
		$contentid = intval($contentid);
		return $this->db->get_one("SELECT `specialid` FROM `$this->table_special_content` WHERE `specialid`=$specialid AND `contentid`=$contentid");
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE `specialid`=$id");
		}
		return true;
	}

	function elite($specialid, $value)
	{
		$specialid = intval($specialid);
		$value = $value == 1 ? 1: 0;
		return $this->db->query("UPDATE `$this->table` SET `elite`='$value' WHERE `specialid`=$specialid");
	}

	function get_id($where)
	{
		if(!$where) return false;
		return $this->db->get_one("SELECT `specialid` FROM `$this->table` WHERE 1 $where");
	}

	function disable($specialid, $value)
	{
		$specialid = intval($specialid);
		$value = $value == 1 ? 1: 0;
		return $this->db->query("UPDATE `$this->table` SET `disabled`='$value' WHERE `specialid`=$specialid");
	}
}
?>