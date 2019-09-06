<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if(!class_exists('member'))
{
	require_once MOD_ROOT.'include/member.class.php';
}

class member_admin extends member
{
	function add($info = array())
	{
		if(!is_array($info))
		{
			$this->msg = 'username_not_accord_with_critizen';
			return false;
		}
		if(!$this->is_username($info['username']))
		{
			$this->msg = 'username_not_accord_with_critizen';
			return false;
		}
		if(!$this->username_exists($info['username']))
		{
			$this->msg = 'username_is_used';
			return false;
		}
		if(!$this->is_password($info['password']))
		{
			$this->msg = 'password_not_less_than_3_longer_than_20';
			return false;
		}
		if(!is_email($info['email']))
		{
			$this->msg = 'input_valid_email';
			return false;
		}
		if($this->email_exists($info['email']))
		{
			$this->msg = 'have_used_change_one_email';
			return false;
		}
		if(empty($info['groupid']))
		{
			$this->msg = 'select_group';
			return false;
		}
		$info['password'] = $this->password($info['password']);
		$info['amount'] = $this->M['defaultamount'];
		$info['point'] = $this->M['defaultpoint'];
		$info['regip'] = IP;
		$info['regtime'] = TIME;
		$info['answer'] = md5($memberinfo['answer']);
		$member_fields = array('username','password','email','groupid','areaid','amount','point','modelid');
		$info['modelid'] = $info['modelid'] ? intval($info['modelid']): 10;
		$arr_userid = array('userid'=>$userid);
		$this->edit_model($info['modelid'], $arr_userid);
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
		unset($info);
        $this->db->insert($this->table, $arr_info);
		$arr_info['userid'] = $moreinfo['userid'] = $userid = $this->db->insert_id();
        $this->db->insert($this->table_cache, $arr_info);
       	$this->db->insert($this->table_info, $moreinfo);
		return $userid;
	}
	
	function move($userid, $groupid)
	{
		$groupid = intval($groupid);
		if($groupid < 1) return false;
		$array = array('groupid'=>$groupid);
		$this->db->update($this->table, $array, "userid IN ($userid)");
		$this->db->update($this->table_cache, $array, "userid IN ($userid)");
		return true; 
	}

	function edit_user($memberinfo)
	{
		if(!is_array($memberinfo)) return false;
		$userid = intval($memberinfo['userid']);
		if ($userid < 1) return false;
		if(isset($memberinfo['username']) && !$this->is_username($memberinfo['username']))
		{
			return false;
		}
		$member_fields = array('username', 'email', 'groupid', 'amount', 'message', 'point', 'areaid', 'modelid');		if(isset($memberinfo['password']) && !empty($memberinfo['password']))
		{
			$this->edit_password($userid, $memberinfo['password']);
		}
		$member_info_fields = $this->db->get_fields($this->table_info);
		$memberinfo['modelid'] = $memberinfo['modelid'] ? intval($memberinfo['modelid']): 10;
		foreach ($memberinfo as $k=>$value)
		{
			if (in_array($k, $member_fields))
			{
				$info[$k] = $value;
			}
			elseif(in_array($k, $member_info_fields))
			{
				$moreinfo[$k] = $value;
			}
		}
		unset($memberinfo);
		if(is_array($info))
		{
			if(isset($info['username']))
			{
				$arr_username = array('username'=>$info['username']);
				$this->db->update($this->table_admin, $arr_username, "userid='$userid'");
			}
			if(isset($info['email']))
			{
				if(!is_email($info['email']))
				{
					$this->msg = 'input_valid_email';
					return false;
				}
				$email = $this->db->get_one("SELECT email FROM $this->table_cache WHERE email='$info[email]' AND userid!='$userid'");
				if($email)
				{
					$this->msg = 'have_used_change_one_email';
					return false;
				}
			}
			$modelid = $this->db->get_one("SELECT modelid FROM $this->table_cache WHERE userid='$userid'");
			if($info['modelid'] && $info['modelid'] != $modelid['modelid'])
			{
				$this->delete_model($userid, $modelid['modelid']);
				$arr_userid = array('userid'=>$userid);
				$this->edit_model($info['modelid'], $arr_userid);
			}
			$this->db->update($this->table, $info, "userid='$userid'");
			$this->db->update($this->table_cache, $info, "userid='$userid'");
		}
		if(is_array($moreinfo))
		{
			if($this->M['enableQchk'])
			{
				if(isset($moreinfo['answer']) && !empty($moreinfo['answer']) && empty($moreinfo['question']))
				{
					$this->msg = 'input_password_clue_question';
					return false;
				}
				$moreinfo['answer'] = md5($moreinfo['answer']);
			}
			$this->db->update($this->table_info, $moreinfo, "userid='$userid'");
		}
		return $userid;
	}

	function model_move($frommodelid, $tomodelid)
	{
		$frommodelid = intval($frommodelid);
		$tomodelid = intval($tomodelid);
		if($tomodelid < 1 || $frommodelid < 1) return false;
		$arr_model = array('modelid'=>$tomodelid);
		$this->db->update($this->table, $arr_model, "modelid='$frommodelid'");
		$this->db->update($this->table_cache, $arr_model, "modelid='$frommodelid'");
		$tablename = DB_PRE.'member_'.$this->MODEL[$frommodelid]['tablename'];
		$this->db->query("TRUNCATE TABLE $tablename");
		return true;
	}

	function delete_model($userid, $modelid)
	{
		$modelid = intval($modelid);
		if($modelid < 1 || !isset($this->MODEL[$modelid])) return false;
		$userid = intval($userid);
		if($userid < 1) return false;
		$tablename = DB_PRE.'member_'.$this->MODEL[$modelid]['tablename'];
		return $this->db->query("DELETE $tablename FROM `$tablename`, `$this->table_cache` WHERE `$tablename`.userid=`$this->table_cache`.userid AND `$tablename`.userid='$userid'");
		return true;
	}
	
	/**
	 * 查询用户信息
	 *
	 * @param string $where
	 * @param char $order
	 * @param int $page
	 * @param int $pagesize
	 * @return 所有用户信息
	 */
	function listinfo($where = '', $order = '', $page = 1, $pagesize = 100)
	{
		global $AREA;
		$limit = $result = '';
		if($where) $where = " $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table_cache m, $this->table_info i  WHERE m.userid=i.userid $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$r['area'] = $AREA[$r['areaid']]['name'];
			$r['lastlogintime'] = $r['lastlogintime'] ? date('Y-m-d H:i:s', $r['lastlogintime']) : '';
			$array[] = $r;
		}
      	$this->db->free_result($result);
		return $array;
	}
	
	function check($userid)
	{
		if(!is_array($userid)) return false;	
		foreach ($userid as $val)
		{
			$this->set_group($val, 6);
		}
		return true;
	}

	/**
	 * 利用用户ID设定用户组
	 *
	 * @param INT $userid
	 * @param INT $new_groupid
	 */
	function set_group($userid, $groupid)
	{
		$userid = intval($userid);
		$groupid = intval($groupid);
		if ($groupid <= 0 || $userid <= 0) return false;
		$group = array('groupid'=>$groupid);
		$this->db->update($this->table, $group, "userid='$userid'");
		return $this->db->update($this->table_cache, $group, "userid='$userid'");
	}

	/**
	 * 用户信息面板菜单接口
	**/
	function memeber_view_menu($userid)
	{
		global $MODULE;
		
		foreach($MODULE as $mod)
		{
			$cache = cache_read('member.menu.php', PHPCMS_ROOT.$mod['url'].'api/');
			if($cache)
			{
				foreach($cache as $k=>$c)
				{
					$c['url'] .= strpos($c['url'], '?') !== false ? '&' : '?';
					if('userid' == $c['key'])
					{									
						$c['url'] .= 'userid=';	
					}
					elseif('username' == $cache[key($cache)]['key'])
					{
						$c['url'] .= 'username=';	
					}
					$arr_c[$k] = $c;
				}
			} 
		}
		return $arr_c;
	}

	/**
	 * 根据用户ID,封锁用户
	 *
	 * @param INT $userid
	 * @param INT $val
	 * @return 返回影响的行数
	 */
	function lock($userid, $val = 1)
	{
		$userids = is_array($userid) ? implode(',', $userid) : intval($userid);
		$disabled = (intval($val) == 1) ? 1 : 0;
		$this->db->query("UPDATE ".$this->table." SET disabled=$disabled WHERE userid IN ('$userids')");
		$this->db->query("UPDATE ".$this->table_cache." SET disabled=$disabled WHERE userid IN ('$userids')");
		return true;
	}
}
?>