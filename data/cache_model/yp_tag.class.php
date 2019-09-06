<?php
class yp_tag
{
	var $modelid;
	var $fields;
	var $table;

    function __construct($modelid)
    {
		global $db,$MODEL;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->table = $MODEL[$modelid]['tablename'];
		$this->fields = $this->modelid ? cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH) : cache_read('common_fields.inc.php', 'fields/');
    }

	function yp_tag($modelid)
	{
		$this->__construct($modelid);
	}

	function get($fields, $where, $orderby)
	{
		global $MODEL;
		$content_table_fields = $this->db->get_fields(DB_PRE.'yp_'.$this->table);
		foreach($this->fields as $field=>$v)
		{
			if($field == 'catid') continue;
			$func = $v['formtype'];
			if(!$v['iswhere'] || !method_exists($this, $func)) continue;
			$value = isset($where[$field]) ? $where[$field] : '';
			$wheresql[$field] = $this->$func($field, $value);
		}

		$tablename = "`".DB_PRE."yp_$this->table`";
		$whereunion = ' status=99 ';
		$fields = implode(',', $fields);
		$wheresql = implode(' AND ', array_filter($wheresql));
		$wheresql = !empty($wheresql) ? ' AND '.$wheresql : '';
		if(isset($where['catid'])) $wheresql .= $this->catid('catid', $where['catid']);
		$sql = "SELECT $fields FROM $tablename WHERE $whereunion $wheresql ORDER BY $orderby";
		return $sql;
	}

    function areaid($field, $value)
    {
	     return $value === '' ? '' : " `areaid`='$value' "; 
    }
    function author($field, $value)
    {
	     return $value === '' ? '' : " `$field`='$value' "; 
    }
	function box($field, $value)
	{
		return $value === '' ? '' : " `$field`='$value' ";
	}
    function catid($field, $value)
    {
	     return $value === '' ? '' : '".get_sql_catid('.$value.')."'; 
    }
	function datetime($field, $value)
	{
		return $value === '' ? '' : " `$field`='$value' ";
	}
	function image($field, $value)
	{
		return $value === '' ? '' : " `$field`!='' ";
	}
	function keyword($field, $value)
	{
	    if($value === '') return '';
		$value = str_replace(array('\'','"'), array('',''), $value);
	    if(strpos($value, ' '))
		{
		    $tags = array_map('trim', explode(' ', $value));
			$tags = "'".implode("','", $tags)."'";
			$where = "k.`tag` IN($tags)";
		}
		else
		{
			$where = "k.`tag`='$value'";
		}
		return array(DB_PRE.'content_tag','contentid',$where);
	}
	function number($field, $value)
	{
		return $value === '' ? '' : " `$field`='$value' ";
	}
    function posid($field, $value)
    {
		return ($value === '' || $value == 0) ? '' : array(DB_PRE.'content_position','contentid',"p.posid=$value");
	}
	function text($field, $value)
	{
		return $value === '' ? '' : " `$field`='$value' ";
	}
	function textarea($field, $value)
	{
		return $value === '' ? '' : " `$field`='$value' ";
	}
    function typeid($field, $value)
    {
	     return $value ? " `typeid`='$value' " : ''; 
    }
    function userid($field, $value)
    {
	     return $value === '' ? '' : " `userid`='$value' "; 
    }
}
?>