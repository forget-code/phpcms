<?php
class member_form
{
	var $db;
	var $modelid;
	var $fields;
	var $userid;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
		
	}

	function member_form($modelid)
	{
		$this->__construct($modelid);
	}
	
	function get($data = array())
	{
		global $_roleid, $_groupid;
		if(isset($data['userid'])) $this->userid = $data['userid'];
		$info = array();
		if(empty($this->fields)) return false;
		foreach($this->fields as $field=>$v)
		{
			if(check_in($_roleid, $v['unsetroleids']) || check_in($_groupid, $v['unsetgroupids'])) continue;
			$func = $v['formtype'];
			$value = isset($data[$field]) ? $data[$field] : '';
			$form = $this->$func($field, $value, $v);
			$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$v['minlength']);
		}
		return $info;
	}

}?>