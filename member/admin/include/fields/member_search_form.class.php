<?php
class member_search_form
{
	var $db;
	var $modelid;
	var $fields;
	var $common_fields;
	var $model_fields;
	var $userid;
	var $order;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->model_fields = $this->modelid ? cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH) : '';
		$this->common_fields = cache_read('common_fields.inc.php', PHPCMS_ROOT.'member/admin/include/fields/');
        $this->fields = $this->modelid ? array_merge($this->common_fields, $this->model_fields) : $this->common_fields;
        $this->set();
    }

	function member_search_form($modelid)
	{
		$this->__construct($modelid);
	}

	function set()
	{
		$this->where = array();
		if(!is_array($this->fields) || empty($this->fields)) return false;
		foreach($this->fields as $field=>$v)
		{
			$func = $v['formtype'];
			if($v['issearch'] && method_exists($this, $func))
			{
				$value = isset($_GET[$field]) ? $_GET[$field] : '';
				$form = $this->$func($field, $value, $v);
				$this->where[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$v['minlength']);
			}
			if($v['isorder'])
			{
				$pre = isset($this->common_fields[$field]) ? 'a.' : 'b.';
				$this->order[$pre.$field.' ASC'] = $v['name'].' 升序';
				$this->order[$pre.$field.' DESC'] = $v['name'].' 降序';
			}
		}
		return true;
	}

	function get_where()
	{
		return $this->where;
	}

	function get_order()
	{
		return $this->order;
	}

}?>