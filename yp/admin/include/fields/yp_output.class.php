<?php
class yp_output
{
	var $fields;
	var $data;

    function __construct()
    {
		global $db, $CATEGORY;
		$this->db = &$db;
		$this->CATEGORY = $CATEGORY;
    }

	function yp_output()
	{
		$this->__construct();
	}

	function set_catid($catid)
	{
		$modelid = $this->CATEGORY[$catid]['modelid'];
		$this->modelid = $modelid;
		$this->fields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
	}

	function get($data)
	{
		$this->data = $data;
		$this->contentid = $data['contentid'];
		$this->set_catid($data['catid']);
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