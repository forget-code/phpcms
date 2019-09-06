<?php
class model_form
{
	var $modelid;
	var $fields;
	var $vid;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function model_form($modelid)
	{
		$this->__construct($modelid);
	}

	function get($data = array())
	{
		global $_roleid,$_groupid;
		if(isset($data['vid'])) $this->vid = $data['vid'];
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
				if(defined('IN_ADMIN'))
				{
					if($v['isbase'])
					{
						$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
						$info['base'][$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star);
					}
					else
					{
						$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
						$info['senior'][$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star);
					}
				}
				else
				{
					$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
					$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star);
				}
			}
		}
		return $info;
	}
}?>