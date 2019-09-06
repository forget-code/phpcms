<?php 
class admin
{
	var $db;
	var $userid;
	var $pages;
	var $number;
	var $table;
	var $table_member;
	var $table_member_cache;
	var $table_role;
	var $table_admin_role;

    function __construct($userid = 0)
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'admin';
		$this->table_role = DB_PRE.'role';
		$this->table_member = DB_PRE.'member';
		$this->table_member_cache = DB_PRE.'member_cache';
		$this->table_member_info = DB_PRE.'member_info';
		$this->table_admin_role = DB_PRE.'admin_role';
		$this->table_session = DB_PRE.'session';
		$this->userid = intval($userid);
    }

	function admin($userid = 0)
	{
		$this->__construct($userid);
	}

	function get($userid = 0)
	{
		if($userid) $this->userid = intval($userid);
		$admin = $this->db->get_one("SELECT * FROM $this->table WHERE userid='$this->userid'");
		$admin['roleids'] = $this->get_admin_role();
		return $admin;
	}

	function add($admin, $roleids)
	{
		if(!is_array($admin) || empty($admin['username']))
		{
			$this->error('admin_add_is_null');
			return false;
		}
		$userid = $this->check($admin['username']);
		if(!$userid) return false;
		if(!is_array($roleids) || empty($roleids))
		{
			$this->error('role_cant_be_null');
			return false;
		}
		$admin['userid'] = $this->userid = $userid;
		$admin['editpasswordnextlogin'] = isset($admin['editpasswordnextlogin']) ? 1 : 0;
		$admin['alloweditpassword'] = isset($admin['alloweditpassword']) ? 1 : 0;
		$admin['allowmultilogin'] = isset($admin['allowmultilogin']) ? 1 : 0;
		$result = $this->db->insert($this->table, $admin);
		$this->db->update($this->table_member, array('groupid'=>1), "userid='$userid'");
		$this->db->update($this->table_member_cache, array('groupid'=>1), "userid='$userid'");
		$this->set_admin_role($roleids);
		return $result;
	}

	function edit($admin, $roleids)
	{
		if(!$this->userid || !is_array($admin))
		{
			$this->error('admin_edit_is_null');
			return false;
		}
		if(!is_array($roleids) || empty($roleids))
		{
			$this->error('role_cant_be_null');
			return false;
		}
		$admin['editpasswordnextlogin'] = isset($admin['editpasswordnextlogin']) ? 1 : 0;
		$admin['alloweditpassword'] = isset($admin['alloweditpassword']) ? 1 : 0;
		$admin['allowmultilogin'] = isset($admin['allowmultilogin']) ? 1 : 0;
		$this->set_admin_role($roleids);
		$this->db->update($this->table_member, array('groupid'=>1), "userid='$this->userid'");
		$this->db->update($this->table_member_cache, array('groupid'=>1), "userid='$this->userid'");
		return $this->db->update($this->table, $admin, "userid=$this->userid");
	}

	function delete()
	{
		$this->set_admin_role(0);
		$this->db->update($this->table_member, array('groupid'=>4), "userid='$this->userid'");
		$this->db->update($this->table_member_cache, array('groupid'=>6), "userid='$this->userid'");
		return $this->db->query("DELETE FROM $this->table WHERE userid=$this->userid");
	}

	function listinfo($where = '', $order = 'userid', $page = 1, $pagesize = 50)
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		
		if($where && is_array($where))
		{
			$str_where = " WHERE a.userid=b.$where[1] AND $where[2]";
			$unions = "a,$where[0] b";
		}
		elseif($where)
		{
			$str_where = " WHERE $where";
		}
		if($order) $order = " ORDER BY $order";

		$r = $this->db->get_one("SELECT count(*) AS number FROM $this->table $unions $str_where");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $unions $str_where $order $limit");
		
		while($r = $this->db->fetch_array($result))
		{
			$this->userid = $r['userid'];
			$r['roleids'] = $this->get_admin_role();
			$r['roles'] = $this->get_role_name($r['roleids']);
			$memberinfo = $this->get_member_info($r['userid']);
			$array[] = array_merge($memberinfo, $r);
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function listadmin($where = '', $order = 'userid', $page = 1, $pagesize = 50)
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";

		$r = $this->db->get_one("SELECT count(*) AS number FROM $this->table_admin_role $where");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table_admin_role $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}

	function listbyrole($roleid = 0)
	{
		$array = array();
		$roleid = intval($roleid);
		if($roleid) $where = "WHERE r.roleid=$roleid";
		$result = $this->db->query("SELECT a.userid, a.username FROM $this->table a LEFT JOIN $this->table_admin_role r ON a.userid=r.userid $where");
		while($r = $this->db->fetch_array($result))
		{
			$array[$r['userid']] = $r['username'];
		}
        $this->db->free_result($result);
		return $array;
	}

	function count_admin($where = '')
	{
		if($where) $where = " WHERE $where";
		$result = $this->db->get_one("SELECT count(*) as num FROM $this->table_admin_role $where");
		return $result['num'];
	}

	function disable($disabled)
	{
		$disabled = $disabled ? 1 : 0;
		return $this->db->query("UPDATE $this->table SET disabled=$disabled WHERE userid=$this->userid");
	}

	function check($username)
	{
		$userid = $this->exists($this->table, $username);
        if($userid)
		{
			$this->error('username_is_admin');
			return false;
		}
		$userid = $this->exists($this->table_member_cache, $username);
        if(!$userid)
		{
			$this->error('admin_member_not_exists');
			return false;
		}
		return $userid;
	}

	function view($userid)
	{
		$admin = $this->get($userid);
		$memberinfo = $this->get_member_info($userid);
		return array_merge($memberinfo, $admin);
	}

	function get_member_info($userid)
	{
		$userid = intval($userid);
		return $this->db->get_one("SELECT * FROM $this->table_member_cache m,$this->table_member_info i WHERE m.userid=i.userid AND m.userid=$userid");
	}

	function listrole()
	{
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table_role WHERE disabled=0 ORDER BY listorder,roleid");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		return $array;
	}

	function get_role_name($roleids)
	{
        global $ROLE;
		$roles = '';
		foreach($roleids as $roleid)
		{
			$roles .= $ROLE[$roleid].'<br />';
		}
		return $roles;
	}

	function get_admin_role()
	{
		$array = array();
		$result = $this->db->query("SELECT roleid FROM $this->table_admin_role WHERE userid=$this->userid");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r['roleid'];
		}
		return $array;
	}

	function set_admin_role($roleids)
	{
		$this->db->query("DELETE FROM $this->table_admin_role WHERE userid=$this->userid");
		foreach($roleids as $roleid)
		{
			$this->db->query("INSERT INTO $this->table_admin_role (userid, roleid) VALUES ($this->userid, $roleid)");
		}
		return true;
	}
	
	function update_admin_role($userid)
	{
		$result = $this->db->query("SELECT roleid FROM $this->table_admin_role WHERE `userid`='$userid'");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r['roleid'];
		}
		cache_write('admin_role_'.$userid.'.php',$array);
		return true;
	}

	function exists($table, $username)
	{
		$r = $this->db->get_one("SELECT `userid` FROM `$table` WHERE `username`='$username'");
		return $r ? $r['userid'] : false;
	}

	function is_multilogin($userid)
	{
		$userid = intval($userid);
		$r = $this->db->get_one("SELECT `ip` FROM `$this->table_session` WHERE `userid`=$userid");
		return ($r && $r['ip'] != IP);
	}

	function update($userid, $field, $value)
	{
		$userid = intval($userid);
        return $this->db->query("UPDATE `$this->table` SET `$field`='$value' WHERE `userid`=$userid");
	}

	function error($error)
	{
		$msg = array(
			         'username_is_admin'=>'该用户已经是管理员',
			         'username_is_not_admin'=>'该用户不是管理员',
			         'admin_member_not_exists'=>'用户名不存在',
			         'admin_add_is_null'=>'用户名不能为空',
			         'admin_edit_is_null'=>'用户名不能为空',
			         'admin_userid_wrong'=>'userid 参数错误',
					 'role_cant_be_null'=>'权限不能为空',
			        );
		$this->errormsg = $msg[$error];
	}

	function errormsg()
	{
		return $this->errormsg;
	}
}
?>