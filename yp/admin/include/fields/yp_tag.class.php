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

}?>