<?php
class times
{
	var $db;
	var $table;
    
    function __construct($action = '')
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'times';
		$this->action = $action;
    }

	function times($action = '')
	{
		$this->__construct($action);
	}

	function set($action, $interval = 3600, $times = 1)
	{
		$this->action = $action;
		$interval = max(intval($interval), 1);
		$times = max(intval($times), 1);
		$this->starttime = TIME - $interval;
		$this->times = $times;
	}

	function get()
	{
		return $this->db->get_one("SELECT `time`,`times` FROM `$this->table` WHERE `action`='$this->action' AND `ip`='".IP."'");
	}

	function add()
	{
		$r = $this->db->get_one("SELECT `time`,`times` FROM `$this->table` WHERE `action`='$this->action' AND `ip`='".IP."'");
		if($r)
		{
			$times = $r['time'] < $this->starttime ? 1 : "`times`+1";
			$this->db->query("UPDATE `$this->table` SET `time`='".TIME."', `times`=$times WHERE `action`='$this->action' AND `ip`='".IP."'");
		}
		else
		{
			$this->db->query("INSERT INTO `$this->table`(`action`,`ip`,`time`,`times`) VALUES('$this->action','".IP."', '".TIME."', times+1)");
		}
	}

	function check()
	{
		return $this->db->get_one("SELECT `time`,`times` FROM `$this->table` WHERE `action`='$this->action' AND `ip`='".IP."' AND `time`>=$this->starttime AND `times`>=$this->times");
	}

	function clear()
	{
		return $this->db->query("DELETE FROM `$this->table` WHERE `action`='$this->action' AND (`ip`='".IP."' OR `time`<$this->starttime)");
	}
}
?>