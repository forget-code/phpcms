<?php
class copyfrom
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'copyfrom';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function copyfrom()
	{
		$this->__construct();
	}

	function get($copyfromid)
	{
		$copyfromid = intval($copyfromid);
		if($copyfromid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE copyfromid=$copyfromid");
	}

	function add($copyfrom)
	{
		if(!is_array($copyfrom) || empty($copyfrom['name'])) return false;
		if($this->checkcopyfrom($copyfrom['name'])) return false;
        if (!empty($copyfrom['url']))
        {
            if (strpos($copyfrom['url'], 'http://') === false && strpos($copyfrom['url'], 'https://') === false)
            {
                $copyfrom['url'] = 'http://' .trim($copyfrom['url']);
            }
            else
            {
                $copyfrom['url'] = trim($copyfrom['url']);
            }
        }
		return $this->db->insert($this->table, $copyfrom);
	}

	function edit($copyfromid, $copyfrom)
	{
		if(!$copyfromid || !is_array($copyfrom) || empty($copyfrom['name'])) return false;
		if($this->checkcopyfrom($copyfrom['name'], $copyfromid)) return false;
        if (!empty($copyfrom['url']))
        {
            if (strpos($copyfrom['url'], 'http://') === false && strpos($copyfrom['url'], 'https://') === false)
            {
                $copyfrom['url'] = 'http://' .trim($copyfrom['url']);
            }
            else
            {
                $copyfrom['url'] = trim($copyfrom['url']);
            }
        }
		return $this->db->update($this->table, $copyfrom, "copyfromid=$copyfromid");
	}

	function checkcopyfrom($name, $copyfromid)
	{
		if ($copyfromid)
		{
			$copyfromid = intval($copyfromid);
			return $this->db->get_one("SELECT copyfromid FROM $this->table WHERE `name`='$name' AND `copyfromid`!=$copyfromid");
		}
		return $this->db->get_one("SELECT copyfromid FROM $this->table WHERE `name`='$name'");
	}

	function delete($copyfromid)
	{
		$copyfromid = intval($copyfromid);
		if($copyfromid < 1) return false;
		return $this->db->query("DELETE FROM $this->table WHERE copyfromid=$copyfromid");
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

	function cache($where = '', $order = 'listorder,usetimes DESC')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT `name`,`url`,`usetimes`,`updatetime` FROM $this->table $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		cache_write('copyfrom.php', $array);
		return $array;
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE copyfromid=$id");
		}
		return true;
	}

	function disable($copyfromid, $disabled)
	{
		$copyfromid = intval($copyfromid);
		if($copyfromid < 1) return false;
		return $this->db->query("UPDATE $this->table SET disabled=$disabled WHERE copyfromid=$copyfromid");
	}
}
?>