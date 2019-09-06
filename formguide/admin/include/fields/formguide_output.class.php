<?php
class formguide_output
{
	var $db;
	var $formid;
	var $fields;

    function __construct($formid)
    {
		global $db;
		$this->db = &$db;
		$this->formid = $formid;
		if($this->formid < 1) return false;
		$this->fields = cache_read($this->formid.'_formfields.inc.php', CACHE_MODEL_PATH);
    }

    function formguide_output($formid)
    {
    	$this->__construct($formid);
    }
    
	function get($data)
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