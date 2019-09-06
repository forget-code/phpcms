<?php
class member_update
{
	var $modelid;
	var $fields;
	var $userid;
	var $tablename;

    function __construct($modelid, $userid)
    {
		global $db, $MODEL;
		$this->db = &$db;
		$this->modelid = intval($modelid);
		$this->userid = intval($userid);
		$this->tablename = DB_PRE.'member_'.$MODEL[$this->modelid]['tablename'];
		$result = $this->db->get_one("SELECT userid FROM $this->tablename WHERE userid='$this->userid'");
		if(!$result)
		{
			$data = array('userid'=>$this->userid);
			$this->db->update($this->tablename, $data);
		}
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function member_update($modelid, $userid)
	{
		$this->__construct($modelid, $userid);
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