<?php
class model_output
{
	var $fields;
	var $data;

    function __construct()
    {
		global $db, $CATEGORY,$modelid;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->CATEGORY = $CATEGORY;
		$this->fields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function model_output()
	{
		$this->__construct();
	}

	function get($data)
	{
		$this->data = $data;
		$this->vid = $data['vid'];
		$info = array();
		foreach($this->fields as $field=>$v)
		{
			if(!isset($data[$field])) continue;
			$func = $v['formtype'];
			$value = $data[$field];
			$result = method_exists($this, $func) ? $this->$func($field, $data[$field]) : $data[$field];
			if($result !== false) $info[$field] = $result;
		}
		return $info;
	}
}?>