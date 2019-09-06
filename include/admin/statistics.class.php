<?php
class statistics
{
	function statistics()
	{
		$this->__construct();
	}
	
	function __construct(){
		global $db;
		$this->table = DB_PRE.'content';
		$this->db =& $db; 
	}
	
	function count($userid, $startime = '', $stoptime = '', $catid = '')
	{
		if(!empty($startime) && !is_numeric($startime))
		{
			$startime = strtotime($startime." 00:00:00");
			$startime = "AND `inputtime` >= '$startime'";
		}
		elseif (!empty($startime) && is_numeric($startime))
		{
			$startime = "AND `inputtime` >= '$startime'";
		}
		if (!empty($stoptime) && !is_numeric($stoptime)) {
			$stoptime = strtotime($stoptime.' 23:59:59');
			$stoptime = "AND `inputtime` <= '$stoptime'";
		}
		elseif (!empty($stoptime) && is_numeric($stoptime)) 
		{
			$stoptime = "AND `inputtime` <= '$stoptime'";
		}
		if (!empty($catid)) {
			$catid = "AND `catid` = '$catid'";
		}
		$r = $this->db->get_one("SELECT COUNT(contentid) as count FROM ".$this->table." WHERE `userid` = '$userid' $startime $stoptime $catid");
		$count = $r['count'];
		return $count;
	}
	
	function day($userid, $catid = '')
	{
		return $this->count($userid, date('Y-m-d'), date('Y-m-d'), $catid);
	}
	
	function yesterday($userid, $catid = '')
	{
		$time = date('Y-m-d', TIME-86400);
		$startime = strtotime($time." 00:00:00");
		$stoptime = strtotime($time." 23:59:59");
		return $this->count($userid, $startime, $stoptime, $catid);
	}
	
	function week($userid, $catid = '')
	{
		$stoptime = date('Y-m-d');			
		$w = date('w', TIME);
		if($w == 0) $w = 7;
		$w--;
		$startime = strtotime(date('Y-m-d', TIME-$w*86400)." 00:00:00");
		return $this->count($userid, $startime, $stoptime, $catid);
	}
	
	function month($userid, $catid = '')
	{
		$stoptime = date('Y-m-d');
		$startime = strtotime(date('Y-m-0',TIME)." 00:00:00");
		return $this->count($userid, $startime, $stoptime, $catid);
	}
}
?>