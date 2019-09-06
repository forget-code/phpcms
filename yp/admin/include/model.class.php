<?php 
class model
{
	var $db;
	var $pages;
	var $number;
	var $table;
	var $table_field;

	function __construct()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'model';
		$this->table_field = DB_PRE.'model_field';
	}

	function model()
	{
		$this->__construct();
	}

	function get($modelid)
	{
		$modelid = intval($modelid);
		if($modelid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE modelid=$modelid");
	}

	function edit($modelid, $model)
	{
		if(!$modelid || !is_array($model) || empty($model['name']) || empty($model['tablename'])) return false;
		$this->db->update($this->table, $model, "modelid=$modelid");
		$this->cache();
		$this->cache_field($modelid);
		return true;
	}

	function delete($modelid)
	{
		global $CATEGORY;
		$modelid = intval($modelid);
		if($modelid < 1) return false;
		$m = $this->get($modelid);
		if(!$m) return false;
		$this->db->query("DROP TABLE IF EXISTS `".DB_PRE."c_".$m['tablename']."`");
		$this->db->query("DELETE FROM $this->table_field WHERE modelid=$modelid");
		$this->db->query("DELETE FROM $this->table WHERE modelid=$modelid");
		$this->cache();
		$C = load('category.class.php','phpcms','include/admin/');
		foreach($CATEGORY as $catid=>$value)
		{
			if($value['modelid'] != $modelid) continue;
			$C->delete($catid);
		}
		return true;
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 20)
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
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
		$this->db->free_result($result);
		return $array;
	}

	function disable($modelid, $disabled)
	{
		$modelid = intval($modelid);
		if($modelid < 1) return false;
		$this->db->query("UPDATE $this->table SET disabled=$disabled WHERE modelid=$modelid");
		$this->cache();
		return true;
	}

	function import($array)
	{
		if(!is_array($array) || empty($array)) return false;
		if ($this->check_modelname($modelid, $array['name']))
		{
			$this->msg = '模型名称已经存在，请选用其他名称';
			return false;
		}
		if($this->check_tablename($modelid, $array['tablename']))
		{
			$this->msg = '表名已经存在，请选用其他名称';
			return false;
		}
		$this->db->insert($this->table, $array);
		$modelid = $this->db->insert_id();
		@extract($array);
		$arr_search = array('$tablename', '$table_model_field', '$modelid');
		$arr_replace = array(DB_PRE.'c_'.$tablename, DB_PRE.'model_field', $modelid);
		$sql = file_get_contents(PHPCMS_ROOT.'include/admin/import_model.sql');
		$sql = str_replace($arr_search, $arr_replace, $sql);
		sql_execute($sql);
		return $modelid;
	}

	function export($modelid)
	{
		$modelid = intval($modelid);
		if($modelid < 1) return false;
		$arr_model['arr_model'] = $this->db->get_one("SELECT * FROM $this->table WHERE modelid='$modelid'");
		unset($arr_model['arr_model']['modelid']);
		$result = $this->db->query("SELECT * FROM $this->table_field WHERE modelid='$modelid'");
		while ($r = $this->db->fetch_array($result))
		{
			if($r['field'] == 'contentid' || $r['field'] == 'catid' || empty($r['field'])) continue;
			unset($r['fieldid'], $r['modelid']);
			$arr_field['arr_field'][] = $r;
		}
		$array = !empty($arr_field) ? array_merge($arr_model, $arr_field) : $arr_model;
		return $array;
	}

	function rows($table)
	{
		if(!in_array($table, $this->db->tables())) return false;
		$r = $this->db->table_status($table);
		return $r['Rows'];
	}

	function cache()
	{
		@set_time_limit(600);
		cache_common();
		$fields = array();
		$files = glob(PHPCMS_ROOT.'yp/admin/include/fields/*');
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

	function cache_field($modelid)
	{
		require_once 'admin/model_field.class.php';
		$field = new model_field($modelid);
		$field->cache();
		return true;
	}

	function cache_class($fields, $classname)
	{
		$data = '';
		
		foreach($fields as $field)
		{
			$r = @file_get_contents(MOD_ROOT.'admin/include/fields/'.$field.'/'.$classname.'.inc.php');
			if($r) $data .= $r;
		}
		$classfile = 'yp_'.$classname.'.class.php';
		$classcode = @file_get_contents(MOD_ROOT.'admin/include/fields/'.$classfile);
		
		if(!$classcode) return false;
		$data = str_replace('}?>', $data."}\r\n?>", $classcode);
		return file_put_contents(CACHE_MODEL_PATH.$classfile, $data);
	}

	/**
	 * 检测模型的名称是否存在
	 *
	 * @param STRING $modelname
	 * @return unknown
	 */
	function check_modelname($modelid, $modelname)
	{
		return $this->db->get_one("SELECT * FROM $this->table WHERE name='$modelname' AND modelid!='$modelid'");
	}
		
	/**
	 * 检测模型的表名是否存在
	 *
	 * @param STRING $tablename
	 * @return unknown
	 */
	function check_tablename($modelid, $tablename)
	{
		return $this->db->get_one("SELECT * FROM $this->table WHERE tablename='$tablename' AND modelid!='$modelid'");
	}

	function msg()
	{
		global $LANG;
		return $LANG[$this->msg];
	}
}
?>