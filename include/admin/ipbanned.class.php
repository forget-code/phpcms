<?php
class ipbanned
{
	var $db;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'ipbanned';
		$this->cache();
    }

	function ipbanned()
	{
		$this->__construct();
	}

	function update($ip, $expires)
	{
		return $this->db->query("REPLACE INTO `$this->table`(`ip`,`expires`) VALUES('$ip', '$expires')");
	}

	function delete($ip)
	{
		if(!$ip) return false;
		$ips = is_array($ip) ? "'".implode("','", $ip)."'" : $ip;
		$this->db->query("DELETE FROM `$this->table` WHERE `ip` IN($ips)");
	}

	function clear()
	{
		return $this->db->query("DELETE FROM `$this->table` WHERE `expires`<".TIME);
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
		$data = array();
		$result = $this->db->query("SELECT * FROM `$this->table` WHERE expires>".TIME);
		while($r = $this->db->fetch_array($result))
		{
			$data[$r['ip']] = $r['expires'];
		}
		$this->db->free_result($result);
		cache_write('ipbanned.php', $data);
	}
}
?>