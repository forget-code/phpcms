<?php 
class log
{
	var $db;
	var $table;
	var $field;
	var $value;
	var $pages;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'log';
    }

	function log()
	{
		$this->__construct();
	}

	function set($field = '', $value = 0)
	{
		$this->field = $field;
		$this->value = intval($value);
	}

	function get($logid, $fields = '*')
	{
		$r = $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `logid`='$logid'");
		if(!$r) return false;
		if(isset($r['data'])) $r['data'] = string2array($r['data']);
		return $r;
	}

	function add($data = array())
	{
		global $mod, $file, $action, $_userid, $_username;
		if(!is_array($data)) return false;
		$data = $data ? array2string($data) : '';
		$time = date('Y-m-d H:i:s', TIME);
		$querystring = addslashes(QUERY_STRING);
        return $this->db->query("INSERT INTO `$this->table`(`field`,`value`,`module`,`file`,`action`,`querystring`,`data`,`userid`,`username`,`time`,`ip`) VALUES('$this->field','$this->value','$mod','$file','$action','$querystring','$data','$_userid','$_username','$time','".IP."')");
	}

	function listinfo($where, $page = 1, $pagesize = 20)
	{
		if($where) $where = " AND $where";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as `count` FROM `$this->table`  WHERE `field`='$this->field' AND `value`='$this->value' $where");
        $number = $r['count'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` WHERE `field`='$this->field' AND `value`='$this->value' $where ORDER BY `logid` DESC $limit");
		while($r = $this->db->fetch_array($result))
		{
			$r['data'] = string2array($r['data']);
			$array[$r['logid']] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}

	function delete($module = '', $fromdate = '', $todate = '')
	{
		$where = '';
	    if($module) $where .= "AND `module`='$module' ";
	    if($fromdate) $where .= "AND `time`>='$fromdate 00:00:00' ";
	    if($todate) $where .= "AND `time`<='$todate 23:59:59' ";
        return $this->db->query("DELETE FROM `$this->table` WHERE `field`='$this->field' AND `value`='$this->value' $where");
	}

	function clear()
	{
		return $this->db->query("TRUNCATE TABLE `$this->table`");
	}
}
?>