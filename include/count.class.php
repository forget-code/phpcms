<?php
class count
{
	function count()
	{
		$this->__construct();
	}
	
	function __construct()
	{
		global $db;
		$this->db =& $db;
		$this->table = DB_PRE.'hits';
		$this->table_content = DB_PRE.'content';
	}
	
	function add($contentid)
	{
        $contentid = intval($contentid);
		$r = $this->db->get_one("SELECT `catid` FROM `$this->table_content` WHERE `contentid`=$contentid");
        if(!$r) return false;
		$catid = $r['catid'];
		$times = date('Y-m-d');
		$r = $this->db->get_one("SELECT `field` FROM `$this->table` WHERE `field`='catid' AND `value`='$catid' AND `date`='$times'");
		if($r)
		{
			$this->db->query("UPDATE `$this->table` SET `hits`=`hits`+1 WHERE `field`='catid' AND `value`='$catid' AND `date`='$times'");
		}
		else 
		{
			$this->db->query("INSERT INTO ".$this->table." SET hits = 1, field = 'catid', value = '$catid', date = '$times'");
		}
		$this->db->query("UPDATE ".DB_PRE."category SET `hits`=`hits`+1 WHERE `catid`='$catid'");
	}
	
	function get_count($catid, $type = '', $startime = '', $stoptime = '')
	{
		if(!empty($type))
		{
			if ($type == 'day') 
			{
				$data = date('Y-m-d');
				$sql = " AND `date`='$data' ";
			}
			elseif ($type == 'yestoday')
			{
				$data = date('Y-m-d', TIME-86400);
				$sql = " AND `date`='$data' ";
			}
			elseif ($type == 'week')
			{
				$w = date('w', TIME);
				if ($w==0) $w = 7;
				$w--;
				$data = date('Y-m-d', TIME-$w*86400);
				$sql = " AND `date`>='$data' AND `date`<='".date('Y-m-d')."'";
			}
			elseif ($type == 'month')
			{
				$data = date('Y-m');
				$sql = " AND `date` LIKE '$data%'";
			}
			elseif ($type == 'year')
			{
				$data = date('Y');
				$sql = " AND `date` LIKE '$data%'";
			}
		}
		elseif(!empty($startime) || !empty($stoptime))
		{
			$sql_time = '';
			if(!empty($startime)) $sql_time = " AND `date` >= '$startime'";
			if(!empty($stoptime)) $sql_time .= " AND `date` <= '$stoptime'";
		}
		if (!isset($sql_time)) $sql_time = '';
		if(!isset($sql)) $sql = '';
		$r = $this->db->get_one("SELECT sum(hits) AS `hits` FROM ".$this->table." WHERE field = 'catid' AND value = '$catid' $sql $sql_time");
		return $r['hits'];
	}
	
	function count_all($catid)
	{
		$r =  $this->db->get_one("SELECT `hits` FROM ".DB_PRE."category WHERE `catid` = '$catid'");
		return $r['hits'];
	}
	
	function get_data($starttime, $stoptime, $catid)
	{
		$sql_time = '';
		if($startime) $sql_time = " AND `date` >= '$startime'";
		if($stoptime) $sql_time .= " AND `date` <= '$stoptime'";
		if($catid) $where = "AND value='$catid'";
		$r = $this->db->query("SELECT * FROM ".$this->table." WHERE `field`='catid' $where $sql_time");
		while ($s = $this->db->fetch_array($r))
		{
			$d[] = $s;
		}
		return $d;
	}
}
?>