<?php
class member_tag_form
{
	var $modelid;
	var $fields;
	var $member_fields;
	var $userid;
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
    
    function member_tag_form($modelid)
    {
    	$this->__construct($modelid);
    }

	function get($data = array())
	{
		$info = array();
		foreach($this->fields as $field=>$v)
		{
			if(!$v['iswhere']) continue;
			$func = $v['formtype'];
			$value = isset($data[$field]) ? $data[$field] : '';
			$form = $this->$func($field, $value, $v);
			$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$v['minlength']);
		}
		return $info;
	}

}?>