<?php
class formguide_search_form
{
	var $db;
	var $formid;
	var $fields;
	var $common_fields;
	var $userid;
	var $order;
	var $where;

    function __construct($formid)
    {
		global $db;
		$this->db = &$db;
		$this->formid = $formid;
        $this->fields = cache_read($this->formid.'_formfields.inc.php', CACHE_MODEL_PATH);
        $this->set();
    }

	function formguide_search_form($formid)
	{
		$this->__construct($formid);
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