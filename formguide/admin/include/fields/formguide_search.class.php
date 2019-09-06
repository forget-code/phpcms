<?php
class formguide_search
{
	var $db;
	var $formid;
	var $fields;
	var $table;
	var $pages;
	var $sql;
	var $common_fields;
	
	function __construct($formid)
	{
		global $db;
		$this->db = &$db;
		$this->formid = intval($formid);
		if($this->formid < 1) return false;
		$this->common_fields = cache_read('formguide_fields.inc.php', PHPCMS_ROOT.'formguide/admin/include/fields/');
		$this->set_formid();
		$this->set();
	}
	
	function formguide_search($formid)
	{
		$this->__construct($formid);
	}
	
	function set()
	{
		$where = array();
		foreach($this->fields as $field=>$v)
		{
			$func = $v['formtype'];
			if($v['issearch'] && isset($_GET[$field]) && method_exists($this, $func))
			{
				 $where[$field] = $this->$func($field, $_GET[$field]);
			}
		}
		$where = implode(' AND ', array_filter($where));
		if($where) $where = ' WHERE '.$where;
		$orderby = 'dataid DESC';
		$sql = "SELECT * FROM $this->table $where ORDER BY $orderby";
		$this->sql = $sql;
		return true;
	}

	function set_formid()
	{
		global $FORMGUIDE;
		if(!isset($FORMGUIDE[$this->formid])) return false;
		$this->table = DB_PRE.'form_'.$FORMGUIDE[$this->formid]['tablename'];
		$this->fields = $this->modelid ? array_merge($this->model_fields, $this->common_fields) : $this->common_fields;
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