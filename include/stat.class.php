<?php
class stat
{
	var $db;
    
	function stat()
	{
		global $db,$_userid;
		$this->db = &$db;
		$this->tables = $this->db->tables();
	}

	function count($table, $field = '', $type = 'all', $where = '')
	{
		if($type == 'all')
		{
			return $this->table_rows(DB_PRE.$table);
		}
		elseif($type == 'today')
        {
			$time_start = strtotime(date('Y-m-d', TIME).' 00:00:00');
			return $this->count_by_time(DB_PRE.$table, $field, $time_start, 0, $where);
		}
		elseif($type == 'yesterday')
        {
			$yesterday = date('Y-m-d', TIME-86400);
			$time_start = strtotime($yesterday.' 00:00:00');
			$time_end = strtotime($yesterday.' 23:59:59');
			return $this->count_by_time(DB_PRE.$table, $field, $time_start, $time_end, $where);
		}
		elseif($type == 'week')
        {
			$w = date('w', TIME);
			if($w == 0) $w = 7;
			$w--;
			$time_start = date('Y-m-d', TIME-86400*$w);
			$time_start = strtotime($time_start.' 00:00:00');
			return $this->count_by_time(DB_PRE.$table, $field, $time_start, 0, $where);
		}
		elseif($type == 'month')
        {
			$time_start = date('Y-m-0', TIME);
			$time_start = strtotime($time_start.' 00:00:00');
			return $this->count_by_time(DB_PRE.$table, $field, $time_start, 0, $where);
		}
	}

	function count_content($where)
	{
		return cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."content` WHERE $where");
	}

	function count_member($where)
	{
		return cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."member_cache` WHERE $where");
	}

	function count_by_time($table, $field, $fromtime = 0, $totime = 0, $where = '')
	{
		$sql = '';
		if(is_array($where))
		{
			$array_where = $where;
			$where = $array_where[2];
			if($fromtime) $sql .= " AND a.`$field`>=$fromtime ";
			if($totime) $sql .= " AND a.`$field`<=$totime ";
			$where = $where ? $where.$sql : substr($sql, 3);
			if($where) $where = " WHERE $where ";
			return cache_count("SELECT count(*) AS `count` FROM $table a,$array_where[0] m $where");
		}
		else
		{
			if($fromtime) $sql .= "AND `$field`>=$fromtime ";
			if($totime) $sql .= "AND `$field`<=$totime ";
			$where = $where ? $where.$sql : substr($sql, 3);
			if($where) $where = " WHERE $where";
			return cache_count("SELECT count(*) AS `count` FROM $table $where");
		}
	}

	function table_rows($table)
	{
		if(!in_array($table, $this->tables)) return false;
		$r = $this->db->table_status($table);
		return $r['Rows'];
	}
}
?>