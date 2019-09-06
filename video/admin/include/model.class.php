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
		global $db,$mod;
		$this->db = &$db;
		$this->table = DB_PRE.'model';
		$this->table_field = DB_PRE.'model_field';
		$this->mod = $mod;
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

	function cache()
	{
		@set_time_limit(600);
		cache_common();
		$fields = array();
		$files = glob(MOD_ROOT.'admin/include/fields/*');
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
		$classfile = $classname.'.class.php';
		$classcode = @file_get_contents(MOD_ROOT.'admin/include/fields/'.$classfile);
		
		if(!$classcode) return false;
		$data = str_replace('}?>', $data."}\r\n?>", $classcode);
		$classfile = $this->mod.'_'.$classfile;
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