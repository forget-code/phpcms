<?php
	/**
	 * 用户模型添加类
	 */
	class member_model
	{
		var $db;
		var $pages;
		var $number;
		var $table;
		var $table_member;
		var $table_field;
		var $msg;
		/**
		 * 对类进行初始化
		 *
		 */
		function __construct()
		{
			global $db;
			$this->db = &$db;
			$this->table = DB_PRE.'model';
			$this->table_field = DB_PRE.'model_field';
			$this->table_member = DB_PRE.'member_model';
		}

		function member_model()
		{
			$this->__construct();
		}

		/**
		 * 添加新的用户模型模型
		 *
		 * @param ARRAY $model
		 * @return unknown
		 */
		function add($model)
		{
			if(!is_array($model) || empty($model['name']) || empty($model['tablename'])) 
			{
				$this->msg = 'invalid_operation';
				return false;
			}
			if(!preg_match("/^[a-z0-9_][a-z0-9_]+$/", $model['tablename']))
			{
				$this->msg = 'table_must_not_chinese';
				return false;
			}
			if ($this->check_modelname($model['name']))
			{
				$this->msg = 'modelname_existed';
				return false;
			}
			if($this->check_tablename($model['tablename']))
			{
				$this->msg = 'tablename_existed';
				return false;
			}
			$model['name'] = trim($model['name']);
			$model['tablename'] = strtolower($model['tablename']);
			$this->db->insert($this->table, $model);
			$modelid = $this->db->insert_id();
			$arr_search = array('$tablename', '$table_model_field', '$modelid');
			$arr_replace = array(DB_PRE.'member_'.$model['tablename'], DB_PRE.'model_field', $modelid);
			$sql = file_get_contents(PHPCMS_ROOT.'member/admin/include/member_model.sql');
			$sql = str_replace($arr_search, $arr_replace, $sql);
			sql_execute($sql);
			$this->cache();
			$this->cache_field($modelid);
			return true;
		}

		/**
		 * 编辑模块信息
		 *
		 * @param INT $modelid
		 * @return 当编辑成功时返回为真
		 */
		function edit($modelid, $model)
		{
			$modelid = intval($modelid);
			if($modelid < 1) return false;
			if(!is_array($model) || empty($model['name']) || empty($model['tablename'])) return false;
			if ($this->check_modelname($model['name'], $modelid))
			{
				$this->msg = 'modelname_existed';
				return false;
			}
			if($this->check_tablename($model['tablename'], $modelid))
			{
				$this->msg = 'tablename_existed';
				return false;
			}
			$model['name'] = trim($model['name']);
			$this->db->update($this->table, $model, "modelid=$modelid");
			$this->cache();
			$this->cache_field($modelid);
			return true;
		}

		/**
		 * 根据模块ID，删除模块
		 *
		 * @param INT $modelid
		 * @return 如果删除成功则返回真
		 */
		function delete_model($modelid)
		{
			$modelid = intval($modelid);
			if($modelid < 1) return false;
			$m = $this->get($modelid);
			if(!$m) return false;
			$this->db->query("DROP TABLE `".DB_PRE."member_".$m['tablename']."`");
			$this->db->query("DELETE FROM `$this->table_field` WHERE modelid=$modelid");
			$this->cache();
			return $this->db->query("DELETE FROM `$this->table` WHERE modelid=$modelid");
		}

		/**
		 * 根据模块ID,获得模块信息
		 *
		 * @param unknown_type $modelid
		 * @return unknown
		 */
		function get($modelid)
		{
			$modelid = intval($modelid);
			if($modelid < 1) return false;
			return $this->db->get_one("SELECT * FROM `$this->table` WHERE modelid='$modelid'");
		}

		/**
		 * 检测模型的名称是否存在
		 *
		 * @param STRING $modelname
		 * @return unknown
		 */
		function check_modelname($modelname, $modelid = '')
		{
			if($modelid)
			{
				$modelid = intval($modelid);
				if($modelid < 1) return false;
				return $this->db->get_one("SELECT * FROM $this->table WHERE name='$modelname' AND modelid!='$modelid' AND modeltype=2");
			}
			else
			{
				return $this->db->get_one("SELECT * FROM $this->table WHERE name='$modelname'");
			}
		}

		/**
		 * 检测模型的表名是否存在
		 *
		 * @param STRING $tablename
		 * @return unknown
		 */
		function check_tablename($tablename, $modelid = '')
		{
			if($modelid)
			{
				$modelid = intval($modelid);
				if($modelid < 1) return false;
				return $this->db->get_one("SELECT * FROM $this->table WHERE tablename='$tablename' AND modelid!='$modelid' AND modeltype=2");
			}
			else
			{
				return $this->db->get_one("SELECT * FROM $this->table WHERE tablename='$tablename'");
			}
		}

		/**
		 * 显示用户模型信息
		 *
		 * @param STRING $where
		 * @param STRING $order
		 * @param INT $page
		 * @param INT $pagesize
		 * @return 用户信息
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
				$array[] = $r;
			}
			$this->cache();
			$this->number = $this->db->num_rows($result);
    	    $this->db->free_result($result);
			return $array;
		}

		/**
		 * 禁用或者启用模型
		 *
		 * @param INT $modelid
		 * @param INT $disabled
		 * @return 操作结束后返回真值
		 */
		function disable($modelid, $disabled)
		{
			$modelid = intval($modelid);
			if($modelid < 1) return false;
			$disabled = isset($disabled) ? intval($disabled) : 0;
			$disable = array('disabled'=>$disabled);
			return $this->db->update($this->table, $disable, " modelid=$modelid");
		}

		function rows($table)
		{
			if(!in_array($table, $this->db->tables())) return false;
			$r = $this->db->table_status($table);
			return $r['Rows'];
		}

		/**
		 * 根据用户模型获得信息
		 *
		 * @param STRING $fields
		 * @param STRING $where
		 * @return 返回用户信息
		 */
		function get_model_info($where = '', $fields = '*', $orderby = 'modelid ASC')
		{
			$fields = empty($fields) ? '*' : $fields;
			$where = empty($where) ? '' : " AND $where";
			$orderby = empty($orderby) ? '' : 'ORDER BY '.$orderby;
			$sql = "SELECT $fields FROM $this->table WHERE modeltype='2' $where $orderby";
			$result = $this->db->query($sql);
			while ($r = $this->db->fetch_array($result))
			{
				if($r['tablename'])
				{
					$r['tablename'] = DB_PRE.'member_'.$r['tablename'];
				}
				$array[] = $r;
			}
			$this->db->free_result($result);
			return $array;
		}

		function import($array)
		{
			if(!is_array($array['arr_model']) || empty($array['arr_model'])) return false;
			if ($this->check_modelname($modelid, $array['arr_model']['name']) || empty($array['arr_model']['name']))
			{
				$this->msg = '模型名称已经存在，请选用其他名称';
				return false;
			}
			if($this->check_tablename($modelid, $array['arr_model']['tablename']) || empty($array['arr_model']['tablename']))
			{
				$this->msg = '表名已经存在，请选用其他名称';
				return false;
			}
			$this->db->insert($this->table, $array['arr_model']);
			$modelid = $this->db->insert_id();
			@extract($array['arr_model']);
			$arr_search = array('$tablename', '$table_model_field', '$modelid');
			$arr_replace = array(DB_PRE.'member_'.$tablename, DB_PRE.'model_field', $modelid);
			$sql = file_get_contents(PHPCMS_ROOT.'member/admin/include/member_model.sql');
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
				unset($r['fieldid'], $r['modelid']);
				$arr_field['arr_field'][] = $r;
			}
			$array = !empty($arr_field) ? array_merge($arr_model, $arr_field) : $arr_model;
			return $array;
		}

		function cache()
		{
			@set_time_limit(600);
			cache_common();
			$fields = array();
			$files = glob(PHPCMS_ROOT.'member/admin/include/fields/*');
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
			require_once PHPCMS_ROOT.'member/admin/include/model_member_field.class.php';
			$field = new member_model_field($modelid);
			$field->cache();
			return true;
		}

		function cache_class($fields, $classname)
		{
			$data = '';
			foreach($fields as $field)
			{
				$r = @file_get_contents(PHPCMS_ROOT.'member/admin/include/fields/'.$field.'/'.$classname.'.inc.php');
				if($r) $data .= $r;
			}
			$classfile = 'member_'.$classname.'.class.php';
			$classcode = @file_get_contents(PHPCMS_ROOT.'member/admin/include/fields/'.$classfile);
			if(!$classcode) return false;
			$data = str_replace('}?>', $data."}\r\n?>", $classcode);
			return file_put_contents(CACHE_MODEL_PATH.$classfile, $data);
		}

		function msg()
		{
			global $LANG;
			return $LANG[$this->msg];
		}
	}