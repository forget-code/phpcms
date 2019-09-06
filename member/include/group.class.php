<?php 
class group
{
	var $db;
	var $table;
	var $table_group;
	var $pages;
	var $number;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'member_group';
		$this->table_extend = DB_PRE.'member_group_extend';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function group()
	{
		$this->__construct();
	}

	function get($groupid, $fields = '*')
	{
		$groupid = intval($groupid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `groupid`=$groupid");
	}

	function add($data)
	{
		if(!is_array($data) || !$this->check_name($data['name'])) return false;
		return $this->db->insert($this->table, $data);
	}
	
	function check_name($name, $groupid = '')
	{
		if(strlen($name) > 20 || strlen($name) < 3)
		{
			$this->error = 'name_not_correct';
			return false;
		}
		$r = $this->db->get_one("SELECT `groupid` FROM `$this->table` WHERE `name`='$name'");
		if(!$r) return true;
		if(($groupid && $r['groupid'] != $groupid) || (!$groupid && $r))
		{
			$this->error = 'group_existed';
			return false;
		}
		return true;
	}

	function edit($groupid, $data)
	{
		if(!$groupid || !is_array($data) || empty($data['name'])) return false;
		$groupid = intval($groupid);
		if(!$this->check_name($data['name'], $groupid)) return false;
		return $this->db->update($this->table, $data, "`groupid`=$groupid");
	}

	function delete($groupid)
	{
		$groupid = intval($groupid);
		return $this->db->query("DELETE FROM `$this->table` WHERE `groupid`=$groupid");
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) FROM `$this->table` $where");
        $number = $r[0];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function cache($where = 'disabled=0', $order = 'groupid')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` $where $order");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['groupid']] = $r['name'];
		}
		cache_write('member_group.php', $array);
		return $array;
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE `$this->table` SET `listorder`=$listorder WHERE `groupid`=$id");
		}
		return true;
	}

	function disable($groupid, $disabled)
	{
		$groupid = intval($groupid);
		return $this->db->query("UPDATE `$this->table` SET `disabled`=$disabled WHERE `groupid`=$groupid");
	}

	function extend_upgrade($userid, $groupid, $unit, $number, $startdate)
	{
		$r = $this->get($groupid);
		if(!$r)
		{
			$this->error = 'groupid_not_exists';
			return false;
		}
		if(!username($userid))
		{
			$this->error = 'userid_not_exists';
			return false;
		}
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
		$price = $r['price_'.$unit];
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
		$this->db->query("INSERT INTO `$this->table_extend`(`userid`,`groupid`,`unit`,`price`,`number`,`amount`,`startdate`,`enddate`,`ip`,`time`,`disabled`) VALUES('$userid','$groupid','$unit','$price','$number','$amount','$startdate','$enddate','".IP."','".TIME."','0')");
		return true;
	}

	function extend_continue($userid, $groupid, $unit, $number)
	{
		$r = $this->extend_get($userid, $groupid);
		if(!$r)
		{
			$this->error = 'groupid_not_exists';
			return false;
		}
		if(!username($userid))
		{
			$this->error = 'userid_not_exists';
			return false;
		}
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
		$number = intval($number);
		$price = $r['price_'.$unit];
		$amount = $number*$price;
		$today = date('Y-m-d');
		$startdate = $r['enddate'] > $today ? $r['enddate'] : $today;
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
		$startdate = $r['startdate'];
		return $this->db->query("REPLACE INTO `$this->table_extend`(`userid`,`groupid`,`unit`,`price`,`number`,`amount`,`startdate`,`enddate`,`ip`,`time`,`disabled`) VALUES('$userid','$groupid','$unit','$price','$number','$amount','$startdate','$enddate','".IP."','".TIME."','0')");
	}

	function extend_update()
	{
		$today = date('Y-m-d');
		$file = CACHE_PATH.'member_group_extend_update';
		$date = @file_get_contents($file);
		if(!$date || $date != $today)
		{
			$this->db->query("UPDATE `$this->table_extend` SET `disabled`=1 WHERE `enddate`<'$today'");
			file_put_contents($file, $today);
		}
		return true;
	}

	function extend_disable($groupid, $disable=1)
	{
		$groupid = intval($groupid);
		$disable = intval($disable);
		$this->db->query("UPDATE `$this->table_extend` SET `disabled`=$disable WHERE `groupid`=$groupid");
		return true;
	}

	function extend_get($userid, $groupid, $fields = '*')
	{
		$userid = intval($userid);
		$groupid = intval($groupid);
		return $this->db->get_one("SELECT $fields FROM `$this->table_extend` a LEFT JOIN `$this->table` b ON a.groupid=b.groupid WHERE a.`userid`=$userid AND b.`groupid`=$groupid");
	}

	function extend_cancel($userid, $groupid)
	{
		$userid = intval($userid);
		$groupid = intval($groupid);
		return $this->db->query("DELETE FROM `$this->table_extend` WHERE `userid`=$userid AND `groupid`=$groupid");
	}

    function extend_list($userid, $disabled = -1)
    {
		$userid = intval($userid);
		$disabled = intval($disabled);
		$where = $disabled > -1 ? "AND `disabled`=$disabled " : '';
		return $this->db->select("SELECT * FROM `$this->table_extend` WHERE `userid`=$userid $where", 'groupid');
    }

	function extend_group_list($groupid, $disabled = -1)
	{
		$groupid = intval($groupid);
		$disabled = intval($disabled);
		$where = $disabled > -1 ? "AND `disabled`=$disabled " : '';
		return $this->db->select("SELECT * FROM `$this->table_extend` WHERE `groupid`=$groupid $where", 'groupid');
	}

	function group_list($groupid, $disabled = -1)
	{
		$groupid = intval($groupid);
		$disabled = intval($disabled);
		$where = $disabled > -1 ? "AND `disabled`=$disabled " : '';
		$result = $this->db->query("SELECT * FROM `$this->table_extend` WHERE `groupid`=$groupid $where");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->db->free_result($result);
		return $array;
	}

	function msg()
	{
		global $LANG;
		return $LANG[$this->error];
	}
}
?>