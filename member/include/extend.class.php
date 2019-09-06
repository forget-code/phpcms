<?php
class extend
{
	var $db;
	var $table;
	var $table_extend;
	var $pages;
	var $number;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'member_group';
		$this->table_extend = DB_PRE.'member_group_extend';
		$this->today = date('Y-m-d');
    }

	function group()
	{
		$this->__construct();
	}

	function set($userid, $groupid)
	{
		global $GROUP;
		$userid = intval($userid);
		$groupid = intval($groupid);
		if(!isset($GROUP[$groupid]) || !username($userid)) return false;
		$this->userid = $userid;
		$this->groupid = $groupid;
	}

	function get()
	{
		return $this->db->get_one("SELECT * FROM `$this->table_extend` WHERE `userid`=$this->userid AND `groupid`=$this->groupid");
	}

    function add($unit, $number, $price, $startdate)
    {
		if(!in_array($unit, array('y', 'm', 'd')))
		{
			$this->error = 'unit_error';
			return false;
		}
		if(!is_numeric($number))
		{
			$this->error = 'number_error';
			return false;
		}
		if(!is_date($startdate))
		{
			$this->error = 'startdate_error';
			return false;
		}
		$number = intval($number);
		$amount = $number*$price;
		$this->date = load('date.class.php');
		$this->date->set_date($startdate);
		if($unit == 'd')
		{
			$this->date->dayadd($number);
		}
		elseif($unit == 'm')
		{
			$this->date->monthadd($number);
		}
		elseif($unit == 'y')
		{
			$this->date->yearadd($number);
		}
		$enddate = $this->date->get_date();
		$this->db->query("INSERT INTO `$this->table_extend`(`userid`,`groupid`,`unit`,`price`,`number`,`amount`,`startdate`,`enddate`,`ip`,`time`,`disabled`) VALUES('$this->userid','$this->groupid','$unit','$price','$number','$amount','$startdate','$enddate','".IP."','".TIME."','0')");
		return true;
    }

	function edit($unit, $number, $price, $startdate)
	{
		if(!in_array($unit, array('y', 'm', 'd')))
		{
			$this->error = 'unit_error';
			return false;
		}
		if(!is_numeric($number))
		{
			$this->error = 'number_error';
			return false;
		}
		if(!is_date($startdate))
		{
			$this->error = 'startdate_error';
			return false;
		}
		$number = intval($number);
		$amount = $number*$price;
		$this->date = load('date.class.php');
		$this->date->set_date($startdate);
		if($unit == 'd')
		{
			$this->date->dayadd($number);
		}
		elseif($unit == 'm')
		{
			$this->date->monthadd($number);
		}
		elseif($unit == 'y')
		{
			$this->date->yearadd($number);
		}
		$enddate = $this->date->get_date();
		$this->db->query("UPDATE `$this->table_extend` SET `unit`='$unit',`price`='$price',`number`='$number',`amount`='$amount',`startdate`='$startdate',`enddate`='$enddate',`disabled`='$disabled' WHERE `userid`=$this->userid AND `groupid`=$this->groupid");
	}

	function disable($disabled = 1)
	{
		if($disabled != 1) $disabled = 0;
        return $this->db->query("UPDATE `$this->table_extend` SET `disabled`=$disabled WHERE `userid`=$this->userid AND `groupid`=$this->groupid");
	}

	function delete()
	{
        return $this->db->query("DELETE FROM `$this->table_extend` WHERE `userid`=$this->userid AND `groupid`=$this->groupid");
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) AS count FROM $this->table_extend $where");
        $number = $r['count'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table_extend $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function unit($unit)
	{
		$units = array('y'=>'年', 'm'=>'月', 'd'=>'日');
        return isset($units[$unit]) ? $units[$unit] : false;
	}

	function expired($enddate)
	{
		return $enddate < $this->today;
	}

	function errormsg()
	{
		global $LANG;
		return $LANG[$this->error];
	}
}
?>