<?php
class formguide_form
{
	var $formid;
	var $fields;

    function __construct($formid)
    {
		global $db;
		$this->db = &$db;
		$this->formid = $formid;
		$this->fields = cache_read($this->formid.'_formfields.inc.php', CACHE_MODEL_PATH);		
	}

	function formguide_form($formid)
	{
		$this->__construct($formid);
	}
	
	function get($data = array())
	{
		global $_groupid;
		$info = array();
		if(empty($this->fields)) return false;

		foreach($this->fields as $field=>$v)
		{
			if(check_in($_groupid, $v['unsetgroupids'])) continue;
			$func = $v['formtype'];
			$value = isset($data[$field]) ? htmlspecialchars($data[$field], ENT_QUOTES) : '';
			$form = $this->$func($field, $value, $v);
			$info[$field] = array('name'=>$v['name'], 'field'=>$field, 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$v['minlength'], 'islistbackgroud'=>$v['isbackground']);
		}
		return $info;
	}

}?>