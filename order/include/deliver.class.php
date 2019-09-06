<?php 
class deliver
{
	var $db;
	var $table;
	var $userid;
	var $username;

	function __construct()
	{
		global $db, $_userid, $_username, $M;
		$this->db = &$db;
		$this->table = DB_PRE.'order_deliver';
		$this->userid = $_userid;
		$this->username = $_username;
		$this->M = $M;
	}

	function deliver()
	{
		$this->__construct();
	}

	function get($deliverid)
	{
		$deliverid = intval($deliverid);
		return $this->db->get_one("SELECT * FROM `$this->table` WHERE `deliverid`=$deliverid");
	}

	function listinfo($userid)
	{
		$userid = intval($userid);
		return $this->db->select("SELECT * FROM `$this->table` WHERE `userid`=$userid ORDER BY `deliverid` DESC");
	}

	function add($data)
	{
		if(!is_array($data))
		{
			$this->errorno = 201;
			return false;
		}
		if($this->count("`userid`=$this->userid") >= $this->M['maxdelivers'])
		{
			$this->errorno = 202;
			return false;
		}
		extract($data);
        if(empty($consignee) || empty($address) || (empty($mobile) && empty($telephone))) return false;
		$areaid = intval($areaid);
        $this->db->query("INSERT INTO `$this->table`(`userid`, `username`, `consignee`, `areaid`, `address`,`postcode`, `telephone`, `mobile`) VALUES('$this->userid', '$this->username', '$consignee', '$areaid', '$address', '$postcode', '$telephone', '$mobile')");
		return $this->db->insert_id();
	}

	function edit($deliverid, $data)
	{
		if($deliverid < 1 || !is_array($data)) return false;
		extract($data);
        if(empty($consignee) || empty($address) || (empty($mobile) && empty($telephone))) return false;
		$areaid = intval($areaid);
        $this->db->query("REPLACE INTO `$this->table`(`deliverid`, `userid`, `username`, `consignee`, `areaid`, `address`,`postcode`, `telephone`, `mobile`) VALUES('$deliverid', '$this->userid', '$this->username', '$consignee', '$areaid', '$address', '$postcode', '$telephone', '$mobile')");
		return true;
	}

	function delete($deliverid, $userid = 0)
	{
		$where = '';
		if($deliverid)
		{
			$deliverids = is_array($deliverid) ? implodeids($deliverid) : intval($deliverid);
		    $where .= is_numeric($deliverids) ? "AND `deliverid`=$deliverids " : "AND `deliverid` IN($deliverids) ";
		}
		if($userid) $where .= "AND `userid`=$userid ";
		if($where) $where = substr($where, 3);
		$this->db->query("DELETE FROM `$this->table` WHERE $where");
        return true;
	}

	function count($where)
	{
		if($where) $where = "WHERE $where";
		$r = $this->db->get_one("SELECT count(*) AS `count` FROM `$this->table` $where");
		return $r ? $r['count'] : false;
	}

	function errormsg()
	{

	}
}
?>