<?php
class yp_search
{
	var $db;
	var $table;
	var $fields;
	var $common_fields;
	var $modelid;
	var $sql;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = '`'.DB_PRE.'content` a';
        $this->fields = $this->common_fields = cache_read('common_fields.inc.php', 'fields/');
		$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
		if($catid > 0) $this->set_catid($catid);
        $this->set();
    }

	function yp_search()
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
		$orderby = in_array($_GET['orderby'], $this->order) ? $_GET['orderby'] : 'a.contentid DESC';
		if($this->modelid)
		{
			if($where) $where = "AND $where";
			$sql = "SELECT * FROM $this->table WHERE a.contentid=b.contentid $where ORDER BY $orderby";
		}
		else
		{
			if($where) $where = "WHERE $where";
			$sql = "SELECT * FROM $this->table $where ORDER BY $orderby";
		}
		$this->sql = $sql;
		return true;
	}

	function set_catid($catid)
	{
		global $MODEL,$CATEGORY;
		if(!isset($CATEGORY[$catid])) return false;
		$this->modelid = $CATEGORY[$catid]['modelid'];
		if(!isset($MODEL[$this->modelid])) return false;
		$this->table = '`'.DB_PRE.'content` a, `'.DB_PRE.'c_'.$MODEL[$this->modelid]['tablename'].'` b';
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
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

   
	function areaid($field, $value)
    {
	     return ($value === '' || !$value) ? '' : " `areaid`='$value' "; 
    }	function box($field, $value)
	{
		return $value === '' ? '' : " `$field`='$value' ";
	}
    function catid($field, $value)
    {
		$value = get_sql_catid($value);
		$value = str_replace('AND','',$value);
		return $value === '' ? '' : " $value "; 
    }
	function datetime($field, $value)
	{
		$sql = '';
		if(is_numeric($value['start'])) $sql .= "AND `$field`>='$value[start]' ";
		if(is_numeric($value['end'])) $sql .= "AND `$field`<='$value[end]' ";
		if($sql) $sql = substr($sql, 3);
		return $sql;
	}
	function editor($field, $value)
	{
		return $value ? " `$field` LIKE '%$value%' " : '';
    }
	
	function keyword($field, $value)
	{
		if($value)
		{
			$query = $this->db->query("SELECT `contentid` FROM `".DB_PRE."content_tag` WHERE `tag`='$value'");
			while($r = $this->db->fetch_array($query))
			{
				$result[] = $r['contentid'];  
			}
			if(!$result) 
			{
				return " `contentid` IN ('') ";
			}	
			$str_content = implode(",", $result);
		}
		return ($value === '' || $str_content == '') ? '' : " `contentid` IN($str_content) "; 
	}	function number($field, $value)
	{
	    if(is_numeric($value['start']) && is_numeric($value['end']) && $value['start'] == $value['end'])
		{
		    $sql = " `$field`='$value[start]' ";
		}
		else
		{
			$sql = '';
			if(is_numeric($value['start'])) $sql .= "AND `$field`>='$value[start]' ";
			if(is_numeric($value['end'])) $sql .= "AND `$field`<='$value[end]' ";
			if($sql) $sql = substr($sql, 3);
		}
		return $sql;
	}
    
	function posid($field, $value)
    {
		if(!defined('IN_ADMIN')) return false;
		if($value)
		{
			$query = $this->db->query("SELECT `contentid` FROM `".DB_PRE."content_position` WHERE `posid`='$value'");
			while($r = $this->db->fetch_array($query))
			{
				$result[] = $r['contentid'];  
			}
			if(!$result) 
			{
				return " `contentid` IN ('') ";
			}		
			$str_content = implode(",", $result);
		}
	    return ($value === '' || $str_content == '') ? '' : " `contentid` IN('$str_content') "; 
    }	function text($field, $value)
	{
		return $value === '' ? '' : " `$field` LIKE '%$value%' ";
	}
	function textarea($field, $value)
    {
	     return $value ? " `$field`='$value' " : ''; 
    }
	function title($field, $value)
	{
		return $value === '' ? '' : " `$field` LIKE '%$value%' ";
	}    function typeid($field, $value)
    {
	     return $value ? " `typeid`='$value' " : ''; 
    }    function userid($field, $value)
    {
	     return $value === '' ? '' : " `userid`='$value' "; 
    }}
?>