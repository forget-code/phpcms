<?php
class formguide_fields
{
	var $db;
	var $formid;
	var $table;
	var $tablename;
	var $pages;

	function __construct($formid)
	{
		global $db, $FORMGUIDE;
		$this->db = &$db;
		$this->formid = $formid;
		if($this->formid < 1) return false;
		$this->table = DB_PRE.'formguide_fields';
		$this->tablename = DB_PRE.'form_'.$FORMGUIDE[$this->formid]['tablename'];
		$this->fields = cache_read($this->formid.'_formfields.inc.php', CACHE_MODEL_PATH);
	}
	
	function formguide_fields($formid)
	{
		$this->__construct($formid);
	}

	function get($fieldid)
	{
		$fieldid = intval($fieldid);
		if($fieldid < 1) return false;
		$r = $this->db->get_one("SELECT * FROM ".$this->table." WHERE fieldid=$fieldid");
		eval("\$setting = $r[setting];");
		$array = $setting ? array_merge($r, $setting) : $r;
		return $array;
	}
	
	/**
	 * 给表单里添加字段
	 *
	 * @param array $info
	 * @param array $setting
	 * @return unknown
	 */
	function add($info, $setting = array())
	{
		if($this->fieldname_exsited($info['name'], $info['formid']))
		{
			return false;
		}
		if($this->field_exsited($info['field'], $info['formid']))
		{
			return false;
		}
		if(!preg_match("/^[a-zA-Z_][a-zA-Z0-9_]+$/", $info['field']))
		{
			$this->msg = 'field_must_not_chinese';
			return false;
		}
		$this->db->insert($this->table, $info);
		$fieldid = $this->db->insert_id();
		setting_set($this->table, "fieldid=$fieldid", $setting);
		$this->cache();
		return true;
	}
	

	/**
	 * 修改字段信息
	 *
	 * @param INT $fieldid
	 * @param ARRAY $info
	 * @param ARRAY $setting
	 * @return unknown
	 */
	function edit($fieldid, $info, $setting = array())
	{
		if($this->fieldname_exsited($info['name'], $info['formid'], $fieldid))
		{
			return false;
		}
		if($this->field_exsited($info['field'], $info['formid'], $fieldid))
		{
			return false;
		}
		if(!$fieldid || !is_array($info) || empty($info['name'])) return false;
		$this->db->update($this->table, $info, "fieldid=$fieldid");
		setting_set($this->table, "fieldid=$fieldid", $setting);
		$this->cache();
		return true;
	}
	
	/**
	 * 删除表单字段
	 *
	 * @param INT $fieldid
	 * @return unknown
	 */
	function delete($fieldid)
	{
		if(is_array($fieldid))
		{
			array_map(array(&$this, 'delete'), $fieldid);
		}
		else
		{
			$fieldid = intval($fieldid);
			if($fieldid < 1) return false;
			$this->db->query("DELETE FROM $this->table WHERE fieldid='$fieldid'");
			$this->cache();
		}
		return true;
	}
	
	/**
	 * 禁用某表单字段
	 *
	 * @param INT $fieldid
	 * @param TINYINT $disabled
	 * @return unknown
	 */
	function disabled($fieldid, $disabled)
	{
		$fieldid = intval($fieldid);
		if($fieldid < 1) return false;
		$disabled = (intval($disabled) == 1) ? 1 : 0;
		$array = array('disabled'=>$disabled);
		$this->db->update($this->table, $array, "fieldid='$fieldid'");
		$this->cache();
		return true;
	}
	
	function listinfo($where = '', $order = '', $page = 1, $pagesize = 100)
	{
		$array = array();
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$limit = " LIMIT $offset, $pagesize";
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			if($r['setting'])
			{
				eval("\$setting = $r[setting];");
				$r = array_merge($r, $setting);
				unset($r['setting'], $setting);
			}
			$array[] = $r;			
		}
      	$this->db->free_result($result);
		return $array;
	}
	
	function listview($page = 1, $pagesize = 30)
	{
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$limit = " LIMIT $offset, $pagesize";
		$result = $this->db->query("SELECT * FROM $this->tablename $limit");
		$number = $this->db->get_one("SELECT count(*) as num FROM $this->tablename");
		$this->pages = pages($number['num'], $page, $pagesize);
		while($r = $this->db->fetch_array($result))
		{
			foreach($r AS $k=>$v)
			{
				if($this->fields[$k]['isbackground'] || in_array($k, array('userid','dataid', 'datetime', 'ip')))
				{
					$r[$k] = $v;
				}
			}
			$array[] = $r;
		}
		return $array;
	}
	
	function deleteinfo($dataid)
	{
		if(is_array($dataid))
		{
			array_map(array($this, 'deleteinfo'), $dataid);
		}
		else
		{
			$dataid = intval($dataid);
			$this->db->query("DELETE FROM $this->tablename WHERE dataid=$dataid");			
		}
		return true;
	}

	function field_exsited($field, $formid, $fieldid = '')
	{
		if($fieldid)
		{
			return $this->db->get_one("SELECT * FROM $this->table WHERE field='$field' AND formid='$formid' AND fieldid!='$fieldid'");
		}
		else
		{
			return $this->db->get_one("SELECT * FROM $this->table WHERE field='$field'");
		}
	}

	function fieldname_exsited($name, $formid, $fieldid = '')
	{
		if($fieldid)
		{
			$result = $this->db->get_one("SELECT * FROM $this->table WHERE name='$name' AND formid='$formid' AND fieldid!='$fieldid'");
			return $this->db->get_one("SELECT * FROM $this->table WHERE name='$name' AND formid='$formid' AND fieldid!='$fieldid'");
		}
		else
		{
			return $this->db->get_one("SELECT * FROM $this->table WHERE name='$name'");
		}
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE fieldid=$id");
		}
		$this->cache();
		return true;
	}

	/**
	 * 缓存表单的所有字段信息
	 *
	 * @param INT $formid
	 * @return unknown
	 */
	function cache()
	{
		$fields = array();
		$fields = $this->listinfo("formid=$this->formid AND disabled=1", 'listorder, fieldid');
		$tablename = 'phpcms_form_'.$FORMGUIDE[$this->formid]['tablename'];
		$datasource['dataid'] = '信息ID';
		foreach ($fields as $id=>$field)
		{
			$array[$field['field']] = $field;
			$datasource[$field['field']] = $field['name'];
		}
		cache_write($this->formid.'_formfields.inc.php', $array, CACHE_MODEL_PATH);
		if(strtolower(CHARSET) != 'utf-8') $datasource = str_charset(CHARSET, 'utf-8', $datasource);
		cache_write('phpcms_'.$this->tablename.'.php', $datasource, PHPCMS_ROOT.'data/datasource/');
		return true;
	}
	
	function msg()
	{
		global $LANG;
		return $LANG[$this->msg];
	}
}
?>