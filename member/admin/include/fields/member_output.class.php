<?php
class member_output
{
	var $db;
	var $modelid;
	var $userid;
	var $fields;

    function __construct($modelid, $userid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->userid = $userid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

    function member_output($modelid, $userid)
    {
    	$this->__construct($modelid, $userid);
    }
    
	function get($data)
	{
		$info = array();
		if(!is_array($data) || empty($data)) return false;
		foreach($data as $field=>$value)
		{
			if(!isset($this->fields[$field])) continue;
			$func = $this->fields[$field]['formtype'];
			if(!$this->fields[$field]['islist'])
			{
				continue;
			}
			$info[$this->fields[$field]['name']] = method_exists($this, $func) ? $this->$func($field, $value) : $value;
		}
		return $info;
	}
}?>