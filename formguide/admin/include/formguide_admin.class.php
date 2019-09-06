<?php
if(!defined('MOD_ROOT'))
{
	define('MOD_ROOT', PHPCMS_ROOT.''.$MODULE['formguide']['url'].'/');
}

if(!class_exists('formguide'))
{
	require MOD_ROOT.'include/formguide.class.php';
}
class formguide_admin extends formguide
{
	var $pages;
	
	/**
	 * 增加表单向导
	 *
	 * @param ARRAY $info
	 * @param ARRAY $setting
	 * @return  TRUE
 	 */
	function add($info, $setting)
	{
		if(empty($info) || !is_array($info)) 
		{
			return false;
		}
		$info['name'] = trim($info['name']);
		$info['tablename'] = strtolower(($info['tablename']));
		if($this->check_tablename($info['tablename']))
		{
			$this->msg = 'table_exists';
			return false;
		}
		if($this->check_formname($info['name']))
		{
			$this->msg = 'form_exists';
			return false;
		}
		$info['addtime'] = TIME;
		$this->db->insert($this->table, $info);
		$formid = $this->db->insert_id();
		if($setting['enabletime'])
		{
			$setting['starttime'] = strtotime($setting['starttime']);
			$setting['endtime'] = strtotime($setting['endtime']);
		}
		setting_set($this->table, "formid='$formid'", $setting);
		$arr_search = array('$tablename', '$table_model_field');
		$arr_replace = array(DB_PRE.'form_'.$info['tablename'], DB_PRE.'form_field');
		$sql = file_get_contents(PHPCMS_ROOT.'formguide/admin/include/formguide.sql');
		$sql = str_replace($arr_search, $arr_replace, $sql);
		sql_execute($sql);
		$this->cache();
		return $formid;
	}
	
	/**
	 * 修改表单向导
	 *
	 * @param INT $formid
	 * @param ARRAY $info
	 * @param ARRAY $setting
	 * @return unknown
	 */
	function edit($formid, $info, $setting)
	{
		if($this->check_formname($info['name'], $formid))
		{
			$this->msg = 'form_exists';
			return false;
		}
		$this->db->update($this->table, $info, "formid='$formid'");
		if($setting['enabletime'])
		{
			$setting['starttime'] = strtotime($setting['starttime']);
			$setting['endtime'] = strtotime($setting['endtime']);
		}
		setting_set($this->table, "formid='$formid'", $setting);
		return true;
	}
	
	/**
	 * 得到表单向导的数据
	 *
	 * @param INT $formid
	 * @return  $array
	 */
	function get($formid)
	{
		$formid = intval($formid);
		if($formid < 1) return false;
		$result = $this->db->get_one("SELECT * FROM $this->table WHERE formid='$formid'");
		eval("\$setting = $result[setting];");
		$array = $setting ? array_merge($result, $setting) : $result;
		return $array;
	}

	/**
	 * 获得表的条数
	 *
	 * @param string $table
	 * @return unknown
	 */
	function rows($table)
	{
		if(!in_array($table, $this->db->tables())) return false;
		$r = $this->db->table_status($table);
		return $r['Rows'];
	}
	
	function getbydataid($formid, $dataid)
	{
		global $FORMGUIDE;
		$dataid = intval($dataid);
		$formid = intval($formid);
		if($dataid < 1 || $formid < 1) return false;
		$tablename = DB_PRE.'form_'.$FORMGUIDE[$formid]['tablename'];
		$result = $this->db->get_one("SELECT * FROM $tablename WHERE dataid='$dataid'");
		return $result;
	}
	
	/**
	 * 删除表单向导的数据
	 *
	 * @param unknown_type $formid
	 * @return unknown
	 */
	function delete($formid)
	{
		if(is_array($formid))
		{
			array_map(array(&$this, 'delete'), $formid);
		}
		else
		{
			$formid = intval($formid);
			if($formid < 1) return false;
			$form = $this->get($formid);
			if(!$form) return false;
			$this->db->query("DELETE FROM $this->table WHERE formid IN ($formid)");
			$this->db->query("DELETE FROM $this->table_fields WHERE formid IN ($formid)");
			$this->db->query("DROP TABLE `".DB_PRE."form_".$form['tablename']."`");
			cache_delete($formid.'_formfields.inc.php', CACHE_MODEL_PATH);
		}
		return true;
	}
	
	/**
	 * 列出表单向导的所有数据
	 *
	 * @param STRING $where
	 * @param STRING $order
	 * @param INT $page
	 * @param INT $pagesize
	 * @return $array
	 */
	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
        $r = $this->db->get_one("SELECT count(*) AS number FROM $this->table $where");
	    $number = $r['number'];
	    $this->pages = pages($number, $page, $pagesize);
	    $array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			if($r['addtime']) $r['addtime'] = date('Y-m-d H:i', $r['addtime']);
			$array[] = $r;
		}
		$this->db->free_result($result);
		$this->cache();
		return $array;
	}
	
	function cache()
	{
		@set_time_limit(600);
		cache_formguid();
		$fields = array();
		$files = glob(PHPCMS_ROOT.'formguide/admin/include/fields/*');
		foreach($files as $file)
		{
			if(!is_dir($file)) continue;
			$fields[] = basename($file);
		}
		$this->cache_class($fields, 'form');
		$this->cache_class($fields, 'input');
		$this->cache_class($fields, 'update');
		$this->cache_class($fields, 'output');
		$this->cache_class($fields, 'search');
		$this->cache_class($fields, 'search_form');
		$this->cache_class($fields, 'tag');
		$this->cache_class($fields, 'tag_form');
		return true;
	}

	function cache_class($fields, $classname)
	{
		$data = '';
		foreach($fields as $field)
		{
			$r = @file_get_contents(PHPCMS_ROOT.'formguide/admin/include/fields/'.$field.'/'.$classname.'.inc.php');
			if($r) $data .= $r;
		}
		$classfile = 'formguide_'.$classname.'.class.php';
		$classcode = @file_get_contents(PHPCMS_ROOT.'formguide/admin/include/fields/'.$classfile);
		if(!$classcode) return false;
		$data = str_replace('}?>', $data."}\r\n?>", $classcode);
		return file_put_contents(CACHE_MODEL_PATH.$classfile, $data);
	}
	
	function disabled($formid, $val)
	{
		$formid = intval($formid);
		if($formid < 1) return false;
		$val = (intval($val) == 1) ? 1 : 0;
		$array = array('disabled'=>$val);
		$this->db->update($this->table, $array, "formid='$formid'");
		return true;
	}
	
	function check_tablename($tablename, $formid = '')
	{
		if(!preg_match("/^[a-z0-9_][a-z0-9_]+$/", $tablename))
		{
			return true;
		}
		if($formid)
		{
			$formid = intval($formid);
			if($formid < 1) return false;
			return $this->db->get_one("SELECT * FROM $this->table WHERE tablename='$tablename' AND formid!='$formid'");
		}
		else
		{
			return $this->db->get_one("SELECT * FROM $this->table WHERE tablename='$tablename'");
		}
	}

	/**
	 * 检测模型的名称是否存在
	 *
	 * @param STRING $modelname
	 * @return unknown
	 */
	function check_formname($formname, $formid = '')
	{
		if($formid)
		{
			$formid = intval($formid);
			if($formid < 1) return false;
			return $this->db->get_one("SELECT * FROM $this->table WHERE name='$formname' AND formid!='$formid'");
		}
		else
		{
			return $this->db->get_one("SELECT * FROM $this->table WHERE name='$formname'");
		}
	}
}
?>