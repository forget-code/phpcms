<?php
class member_tag
{
	var $db;
	var $modelid;
	var $fields;
	var $common_fields;
	var $model_fields;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->model_fields = $this->modelid ? cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH) : '';
		$this->common_fields = cache_read('common_fields.inc.php', PHPCMS_ROOT.'member/admin/include/fields/');
		$this->fields = $this->modelid ? array_merge($this->model_fields, $this->common_fields) : $this->common_fields;
    }

    function member_tag($modelid)
    {
    	$this->__construct($modelid);	
    }
    
	function get($fields, $where, $orderby)
	{
		global $MODEL;
		if($this->model_fields)
		{
			foreach($fields as $k=>$field)
			{
				$fields[$k] = in_array($field, array_keys($this->common_fields)) ? 'a.'.$field : 'b.'.$field;
			}
			$tablename = "`".DB_PRE."member_cache` a, `".DB_PRE."member_info` i, `".DB_PRE."member_".$MODEL[$this->modelid]['tablename']."` b";
			$whereunion = 'WHERE a.userid=b.userid AND a.userid=i.userid';
		}
		else
		{
			$tablename = "`".DB_PRE."member_cache` a `".DB_PRE."member_info` i";
			$whereunion = 'WHERE a.userid=i.userid';
		}
		$fields = implode(',', $fields);
		foreach($this->fields as $field=>$v)
		{
			$func = $v['formtype'];
			if(!$v['iswhere'] || !method_exists($this, $func)) continue;
			$value = isset($where[$field]) ? $where[$field] : '';
			$field = isset($this->common_fields[$field]) ? 'a.'.$field : 'b.'.$field;
			$wheresql[$field] = $this->$func($field, $value);
		}
		$wheresql = implode(' AND ', array_filter($wheresql));
		$wheresql = !empty($wheresql) ? ' AND '.$wheresql : '';
		$sql = "SELECT $fields FROM $tablename $whereunion $wheresql ORDER BY $orderby";
		return $sql;
	}

}?>