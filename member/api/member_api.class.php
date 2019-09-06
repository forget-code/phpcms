<?php
class member_api
{
	var $db;
	var $table;
	var $table_cache;
	var $table_info;
	var $member_fields;
	var $MODEL;

	/**
	 *初始化用户API类
	**/
	function __construct()
	{
		global $db, $MODEL;
		$this->db = &$db;
		$this->table = DB_PRE.'member';
		$this->table_cache = DB_PRE.'member_cache';
		$this->table_info = DB_PRE.'member_info';
		$this->member_fields = array('username'=>'username', 'email'=>'email', 'groupid'=>'groupid', 'modelid'=>'modelid', 'amount'=>'amount', 'message'=>'message', 'point'=>'point', 'areaid'=>'areaid', 'disabled'=>'disabled');
		foreach($MODEL as $modelid=>$model)
		{
			if($model['modeltype'] == 2)
			{
				$this->MODEL[$modelid] = $model;
			}	
		}
	}

	function member_api()
	{
		$this->__construct();
	}

	/**
	 * 获得用户信息
	 *
	 * @param unknown_type $userid
	 * @param unknown_type $fields
	 * @return unknown
	 */
	function get($userid, $fields = array())
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		if(!is_array($fields)) return false;
		$member_info_fields = $this->db->get_fields($this->table_info);
		$m_fields = array_intersect($fields, $this->member_fields);
		$i_fields = array_intersect($fields, $member_info_fields);
		if($m_fields && $i_fields)
		{
			$str_fields = implode(',', array_merge($m_fields, $i_fields));
			return $this->db->get_one("SELECT $str_fields FROM $this->table_cache m, $this->table_info i WHERE m.userid=i.userid AND m.userid='$userid'");
		}
		elseif($m_fields)
		{
			$str_fields = implode(',', $m_fields);
			return $this->db->get_one("SELECT $str_fields FROM $this->table_cache WHERE userid='$userid'");
		}
		elseif($i_fields)
		{
			$str_fields = implode(',', $i_fields);
			return $this->db->get_one("SELECT $str_fields FROM $this->table_info WHERE userid='$userid'");
		}
		return false;
	}

	function get_userid($username)
	{
		$sql = "SELECT userid FROM $this->table_cache WHERE username='$username' LIMIT 1";
		$user = $this->db->get_one($sql);
		return $user['userid'];
	}

	/**
	 * 修改用户信息
	 *
	 * @param int $userid
	 * @param array $data
	 * @return unknown
	 */
	function set($userid, $data = array())
	{
		global $PHPCMS;
		$userid = intval($userid);
		if ($userid < 1) return false;
		$member_info_fields = $this->db->get_fields($this->table_info);
		if(isset($member_fields['username'])) $this->is_username($memberinfo['username']);
		$m = $i = array();
		$m = array_intersect_key($data, $this->member_fields);
		$i = array_intersect_key($data, $member_info_fields);
		if($m)
		{
			$this->db->update($this->table_cache, $m, "userid='$userid'");
			$this->db->update($this->table, $m, "userid='$userid'");
		}
		if($i) $this->db->update($this->table_info, $i, "userid='$userid'");
		return true;
	}

	function add($info, $import = 0)
	{
		global $M;		
		$member_fields = array('userid', 'username','password','email','groupid','areaid','amount','point','modelid');
		if($info['groupid'])
		{
			$info['groupid'] = intval($info['groupid']);
		}
		else
		{
			$info['groupid'] = $M['enablemailcheck'] ? 4 : ($M['enableadmincheck'] ? 5 : 6);
		}
		$info['modelid'] = $info['modelid'] ? intval($info['modelid']): 10;
		$member_info_fields = $this->db->get_fields($this->table_info);
        foreach($info as $field=>$val)
        {
			if(in_array($field, $member_fields))
			{
				$arr_info[$field] = $val;
			}
			if(in_array($field, $member_info_fields))
			{
				$moreinfo[$field] = $val;
			}
		}
		if(isset($arr_info['password']) && !$import)
		{
			$arr_info['password'] = $this->password($arr_info['password']);
		}
		unset($info);
        $this->db->insert($this->table, $arr_info);
		$arr_info['userid'] = $moreinfo['userid'] = $userid = $this->db->insert_id();
        $this->db->insert($this->table_cache, $arr_info);
       	$this->db->insert($this->table_info, $moreinfo);
		return $userid;
	}

	function password($password)
	{
		return md5(PASSWORD_KEY.$password);
	}

	function check_email_user($username = '', $email = '')
	{
		if($username && $this->db->get_one("SELECT * FROM $this->table_cache WHERE username='$username'"))
		{
			return true;
		}
		if($email && $this->db->get_one("SELECT * FROM $this->table_cache WHERE email='$email'"))
		{
			return true;
		}
		return false;
	}
	
	function get_model_info($userid, $fields = '*')
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		$model_info = $this->db->get_one("SELECT modelid FROM $this->table_cache WHERE userid='$userid'");
		$modelid = intval($model_info['modelid']);
		if(!isset($this->MODEL[$modelid])) return false;
		$modelfields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
		$tablename = DB_PRE.'member_'.$this->MODEL[$modelid]['tablename'];
		if(empty($tablename)) return false;
		return $this->db->get_one("SELECT $fields FROM $tablename WHERE userid='$userid'");
	}

	function edit_model($modelid, $modelinfo)
	{
		$modelid = intval($modelid);	
		if($modelid < 1 || !isset($this->MODEL[$modelid])) return false;
		$tablename = DB_PRE.'member_'.$this->MODEL[$modelid]['tablename'];
		$this->db->update($tablename, $modelinfo);
		return true;
	}

	/**
	 * 删除用户信息
	 *
	 * @param int $userid
	 * @return unknown
	 */
	function del($userid)
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		return $this->db->query("DELETE FROM $this->table, $this->table_cache, $this->table_info WHERE userid='$userid'");
	}
	
	/**
	 * 检查用户名是否符合规定
	 *
	 * @param STRING $username
	 * @return 	TRUE or FALSE
	 */
	function is_username($username)
	{
		$strlen = strlen($username);
		if( $this->is_badword($username) )
		{
			$this->msg = 'username_not_accord_with_critizen';
			return false;
		}
		elseif ( 20 <= $strlen || $strlen <= 2 )
		{
			$this->msg = 'username_not_less_than_3_longer_than_20';
			return false;
		}
		return true;
	}
	
	/**
	 * 检测输入中是否含有错误字符
	 *
	 * @param char $string
	 * @return TRUE or FALSE
	 */
	function is_badword($string)
	{
		$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#");
		foreach($badwords as $value)
		{
			if(strpos($string, $value) !== FALSE)
			{ 
				return TRUE; 
			}
		}
		return FALSE;
	}
}
?>