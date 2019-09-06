<?php
class content_form
{
	var $modelid;
	var $fields;
	var $contentid;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function content_form($modelid)
	{
		$this->__construct($modelid);
	}

	function get($data = array())
	{
		global $_roleid,$_groupid;
		if(isset($data['id'])) $this->contentid = $data['id'];
		$info = array();
		foreach($this->fields as $field=>$v)
		{
			if(defined('IN_ADMIN'))
			{
				if($v['iscore'] || check_in($_roleid, $v['unsetroleids']) || check_in($_groupid, $v['unsetgroupids'])) continue;
			}
			else
			{
				if($v['iscore'] || !$v['isadd'] || check_in($_roleid, $v['unsetroleids']) || check_in($_groupid, $v['unsetgroupids'])) continue;
			}
			$func = $v['formtype'];
			$value = isset($data[$field]) ? htmlspecialchars($data[$field], ENT_QUOTES) : '';
			$form = $this->$func($field, $value, $v);
			if($form !== false)
			{
				$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
				$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star);
			}
		}
		return $info;
	}
}?>