<?php
class keylink
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'keylink';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function keylink()
	{
		$this->__construct();
	}

	function get($keylinkid)
	{
		$keylinkid = intval($keylinkid);
		if($keylinkid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE keylinkid=$keylinkid");
	}

	function checkword($word)
	{
		if(empty($word)) return false;
		$word = trim($word);
		return $this->db->get_one("SELECT * FROM $this->table WHERE word='$word'");
	}

	function add($keylink)
	{
		if(!is_array($keylink) || empty($keylink['word'])) return false;
        if (!empty($keylink['url']))
        {
            if (strpos($keylink['url'], 'http://') === false && strpos($keylink['url'], 'https://') === false)
            {
                $keylink['url'] = 'http://' .trim($keylink['url']);
            }
            else
            {
                $keylink['url'] = trim($keylink['url']);
            }
        }
		return $this->db->insert($this->table, $keylink);
	}

	function edit($keylinkid, $keylink)
	{
		if(!$keylinkid || !is_array($keylink) || empty($keylink['word'])) return false;
        if (!empty($keylink['url']))
        {
            if (strpos($keylink['url'], 'http://') === false && strpos($keylink['url'], 'https://') === false)
            {
                $keylink['url'] = 'http://' .trim($keylink['url']);
            }
            else
            {
                $keylink['url'] = trim($keylink['url']);
            }
        }
		return $this->db->update($this->table, $keylink, "keylinkid=$keylinkid");
	}

	function delete($keylinkid)
	{
		$keylinkid = intval($keylinkid);
		if($keylinkid < 1) return false;
		return $this->db->query("DELETE FROM $this->table WHERE keylinkid=$keylinkid");
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

	function cache($where = '', $order = 'listorder,keylinkid')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = array($r['word'], $r['url']);
		}
		cache_write('keylink.php', $array);
		return $array;
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE keylinkid=$id");
		}
		return true;
	}
}
?>