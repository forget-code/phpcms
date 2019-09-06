<?php
class urlrule
{
	var $db;
	var $table;
	var $pages;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'urlrule';
    }

	function urlrule()
	{
		$this->__construct();
	}

    function listinfo($condition = null, $page = 1, $pagesize = 20)
	{
        $arg['where'] = $this->_make_condition($condition);
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
		$r = $this->db->get_one("SELECT count(*) AS number FROM `$this->table` ");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table WHERE 1 {$arg['where']} ORDER BY `urlruleid` DESC LIMIT $offset, $pagesize");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}

	function add($info)
	{
		if(!is_array($info) || empty($info['file'])) return false;
		$this->db->insert($this->table, $info);
		$typeid = $this->db->insert_id();
		return $typeid;
	}

	function edit($urlruleid, $info)
	{
		if(!$urlruleid || !is_array($info) || empty($info['file'])) return false;
		return $this->db->update($this->table, $info, "urlruleid=$urlruleid");
	}

    function get($urlruleid)
	{
		$urlruleid = intval($urlruleid);
		if($urlruleid < 1) return false;
		return $this->db->get_one("SELECT * FROM `$this->table` WHERE `urlruleid` = $urlruleid");
	}

    function delete($urlruleid)
	{
		$typeid = intval($urlruleid);
		$this->db->query("DELETE FROM `$this->table` WHERE `urlruleid`=$urlruleid");
		return true;
	}

    function _make_condition($conditions)
	{
		$where = '';
        if(is_array($conditions))
		{
			$where .= implode(' AND ', $conditions);
		}
        if ($where)
        {
		    return ' AND ' . $where;
        }
	 }

}
?>