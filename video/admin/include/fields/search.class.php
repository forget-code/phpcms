<?php
class model_search
{
	var $db;
	var $table;
	var $fields;
	var $common_fields;
	var $modelid;
	var $sql;

   function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->table = '`'.DB_PRE.'video` a';
		$this->table_data = '`'.DB_PRE.'video_data` b';
        $this->fields = $this->common_fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
		$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
        $this->set();
    }

	function model_search()
	{
		$this->__construct();
	}

	function set()
	{
		$where = array();
		foreach($this->fields as $field=>$v)
		{
			$func = $v['formtype'];
			if($v['issearch'] && isset($_GET[$field]) && method_exists($this, $func))
			{
				 $where[$field] = $this->$func($field, $_GET[$field]) ;
			}
			if($v['isorder'])
			{
				$pre = isset($this->common_fields[$field]) ? 'a.' : 'b.';
				$this->order[] = $pre.$field.' ASC';
				$this->order[] = $pre.$field.' DESC';
			}
		}
		$where = array_filter($where);
		foreach($where as $field=>$w)
		{
			$pre = isset($this->common_fields[$field]) ? 'a.' : 'b.';
			$where[$field] = $pre.$w;
		}
		$where = implode(' AND ', $where);
		$orderby = in_array($_GET['orderby'], $this->order) ? $_GET['orderby'] : 'a.vid DESC';
		if($this->modelid)
		{
			if($where) $where = "AND $where";
			$sql = "SELECT * FROM $this->table,$this->table_data WHERE a.vid=b.vid $where ORDER BY $orderby";
		}
		else
		{
			if($where) $where = "WHERE $where";
			$sql = "SELECT * FROM $this->table $where ORDER BY $orderby";
		}

		$this->sql = $sql;
		return true;
	}

	function data($page = 1, $pagesize = 20)
	{
		if(!$this->sql) return false;
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$sql_count = preg_replace("/^SELECT([^(]+)FROM(.+)(ORDER BY.+)$/i", "SELECT COUNT(*) AS `count` FROM\\2", $this->sql);
		$this->total = cache_count($sql_count);
		if($this->total == 0) return array();
		$this->pages = pages($this->total, $page, $pagesize);
		$data = array();
		$result = $this->db->query("$this->sql LIMIT $offset, $pagesize");
		while($r = $this->db->fetch_array($result))
		{
			$data[] = $r;
		}
		$this->db->free_result($result);
		return $data;
	}

}?>