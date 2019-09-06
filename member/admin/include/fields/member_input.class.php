<?php
class member_input
{
	var $db;
	var $modelid;
	var $fields;
	var $table;

    function __construct($modelid)
    {
		global $db, $MODEL;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
		$this->table = DB_PRE.'member_'.$MODEL[$this->modelid]['tablename'];
    }

    function member_input($modelid)
    {
    	$this->__construct($modelid);	
    }
    
	function get($data)
	{
		global $_roleid, $_groupid;
		$info = array();
		foreach($data as $field=>$value)
		{
			if(!isset($this->fields[$field]) || check_in($_roleid, $this->fields[$field]['unsetroleids']) || check_in($_groupid, $this->fields[$field]['unsetgroupids'])) continue;
			$name = $this->fields[$field]['name'];
			$minlength = $this->fields[$field]['minlength'];
			$maxlength = $this->fields[$field]['maxlength'];
			$pattern = $this->fields[$field]['pattern'];
			$length = strlen($value);
			if(empty($this->fields[$field]['errortips'])) 
			{
				$errortips = $name.' 不符合要求！';
			}
			else
			{
				$errortips = $this->fields[$field]['errortips'];
			}
			if($minlength && $length < $minlength) showmessage("$name 不得少于 $minlength 个字符！");
			if($maxlength && $length > $maxlength) showmessage("$name 不得超过 $minlength 个字符！");
			if($pattern && $length && !preg_match($pattern, $value)) showmessage($errortips);
            $checkunique_table = $this->fields[$field]['issystem'] ? DB_PRE.'member_cache' : $this->table;
            if($this->fields[$field]['isunique'] && $this->db->get_one("SELECT $field FROM $checkunique_table WHERE `$field`='$value' LIMIT 1")) showmessage("$name 的值不得重复！");
			$func = $this->fields[$field]['formtype'];
			if(method_exists($this, $func)) $value = $this->$func($field, $value);
			if($this->fields[$field]['issystem']) $info['system'][$field] = $value;
			else $info['model'][$field] = $value;
		}
		return $info;
	}

}?>