<?php 
	/**
	 * 用户模型字段添加类
	 */
	class member_model_field
	{
		var $db;
		var $pages;
		var $number;
		var $table;
		var $modelid;
		var $modelname;
		var $tablename;
		var $member_fields;

	    function __construct($modelid)
	    {
			global $db, $MODEL;
			$this->modelid = intval($modelid);
			if($this->modelid < 1) return false;
			$this->db = &$db;
			$this->table = DB_PRE.'model_field';
			$this->modelname = $MODEL[$this->modelid]['name'];
			$this->tablename = DB_PRE.'member_'.$MODEL[$this->modelid]['tablename'];
			$this->member_fields = cache_read('common_fields.inc.php', PHPCMS_ROOT.'member/admin/include/fields/');
	    }
	   
	    function member_model_field($modelid)
	    {
	    	$this->__construct($modelid);	
	    }
	    
	    /**
	     * 添加字段
	     *
	     * @param unknown_type $info
	     * @return unknown
	     */
	   function add($info, $setting = array())
	   {
			if(!is_array($info) || empty($info['field']) || empty($info['name']) || $this->field_exsited($info['modelid'], $info['field'])) return false;
			if(!preg_match("/^[a-zA-Z0-9_][a-zA-Z0-9_]+$/", $info['field']))
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
	    
	   function edit($fieldid, $info, $setting = array())
	   {
			if(!$fieldid || !is_array($info) || empty($info['name'])) return false;
			$this->db->update($this->table, $info, "fieldid=$fieldid");
			setting_set($this->table, "fieldid=$fieldid", $setting);
			$this->cache();
			return true;
	   }
	   
	   /**
	    * 删除用户表字段
	    *
	    * @param INT $fieldid
	    * @return 删除的字段数
	    */
	   function delete_field($fieldid)
	   {
			$fieldid = intval($fieldid);
			if($fieldid < 1) return  false;
			$this->db->query("DELETE FROM $this->table WHERE fieldid=$fieldid");
			$this->cache();
			return true;
	   }

	   /**
	    * 根据字段ID获得字段信息
	    *
	    * @param INT $fieldid
	    * @return 字段的信息
	    */
		function get($fieldid)
		{
			$fieldid = intval($fieldid);
			if($fieldid < 1) return false;
			$r = $this->db->get_one("SELECT * FROM $this->table WHERE fieldid=$fieldid");
			eval("\$setting = $r[setting];");
			$array = $setting ? array_merge($r, $setting) : $r;
			return $array;
		}
		
	   /**
	    * 列出字段信息
	    *
	    * @param STRING $where
	    * @param STRING $order
	    * @param INT $page
	    * @param INT $pagesize
	    * @return ARRAY字段信息
	    */
	   function listinfo($where = '', $order = '', $page = 1, $pagesize = 100)
	   {
			if($where) $where = " WHERE $where";
			if($order) $order = " ORDER BY $order";
			$page = max(intval($page), 1);
        	$offset = $pagesize*($page-1);
        	$limit = " LIMIT $offset, $pagesize";
			$array = array();
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
		
		/**
		 * 缓存所有字段
		 *
		 * @param INT $modelid
		 * @return 缓存字段信息
		 */
		function cache()
		{
			global $MODEL;
			$fields = array();
			$infos = $this->listinfo("modelid=$this->modelid AND disabled=0", 'listorder,fieldid', 1, 100);
			$datasource['userid'] = '用户ID';
			$tablename = 'phpcms_member_'.$MODEL[$this->modelid]['tablename'];
			foreach($infos as $id=>$info)
			{
				$fields[$info['field']] = $info;
				$datasource[$info['field']] = $info['name'];
			}
			if(strtolower(CHARSET) != 'utf-8') $datasource = str_charset(CHARSET, 'utf-8', $datasource);
			cache_write('phpcms_'.$tablename.'.php', $datasource, PHPCMS_ROOT.'data/datasource/');
			cache_write($this->modelid.'_fields.inc.php', $fields, CACHE_MODEL_PATH);
			return true;
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

		function disable($fieldid, $disabled)
		{
			$fieldid = intval($fieldid);
			if($fieldid < 1) return false;
			$disabled = intval($disabled);
			$disable = array('disabled'=>$disabled);
			$this->cache();
			return $this->db->update($this->table, $disable, " fieldid=$fieldid");
		}
		
		/**
		 * 检查表中是否已经存在同名字段
		 *
		 * @param INT $modelid
		 * @param STRING $field
		 * @return 当字段存在时，返回为真
		 */
		function field_exsited($modelid = '' ,$field)
		{
			$modelid = intval($modelid);
			if($modelid < 1) return false;
			$result = $this->db->get_fields($this->tablename);
			$array = array_merge(array_keys($this->member_fields), $result);
			return in_array($field, $array) ? true : false;
		}
	}
?>