<?php
class model_update
{
	var $modelid;
	var $fields;
	var $vid;

    function __construct($modelid, $vid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->vid = $vid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function model_update($modelid, $vid)
	{
		$this->__construct($modelid, $vid);
	}

	function update($data)
	{
		$info = array();
		foreach($data as $field=>$value)
		{
			if(!isset($this->fields[$field])) continue;
			$func = $this->fields[$field]['formtype'];
			$info[$field] = method_exists($this, $func) ? $this->$func($field, $value) : $value;
		}
		return $info;
	}

}?>