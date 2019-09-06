<?php
class member
{
	var $db;
	var $table;
	var $table_cache;
	var $table_info;
	var $table_admin;
    var $_userid;
    var $M;
    var $MODEL;
	var $pages;
	var $cache_group;

    function __construct()
    {
		global $db, $M, $MODEL;
		$this->db = &$db;
		$this->table_admin = DB_PRE.'admin';
		$this->table = DB_PRE.'member';
		$this->table_cache = DB_PRE.'member_cache';
		$this->table_info = DB_PRE.'member_info';
		$this->M = $M;
		foreach($MODEL as $modelid=>$model)
		{
			if($model['modeltype'] == 2)
			{
				$this->MODEL[$modelid] = $model;
			}	
		}
		cache_member();		
    }

    function member()
    {
    	$this->__construct();
    }

    /**
     * 根据用户ID,获得某个用户的信息
     *
     * @param CHAR $fields
     * @param INT $userid
     * @param BOOL $ismore
     * @return ARRAY
     */
	function get($userid, $fields = '*', $ismore = 0)
	{
		$userid = intval($userid);
		$sql = $ismore ? "SELECT $fields FROM $this->table_cache m LEFT JOIN $this->table_info i ON m.userid=i.userid WHERE m.userid='$userid'" : "SELECT $fields FROM $this->table_cache WHERE userid='$userid'";
		return $this->db->get_one($sql);
	}

    /**
     * 根据整合系统用户ID,获得某个用户的信息
     *
     * @param CHAR $fields
     * @param INT $touserid
     * @param BOOL $ismore
     * @return ARRAY
     */
	function get_by_touserid($touserid, $fields = '*', $ismore = 0)
	{
		$touserid = intval($touserid);
		$sql = $ismore ? "SELECT $fields FROM $this->table_cache m LEFT JOIN $this->table_info i ON m.userid=i.userid WHERE m.touserid='$touserid'" : "SELECT $fields FROM $this->table_cache WHERE touserid='$touserid'";
		return $this->db->get_one($sql);
	}

	/**
     * 根据用户名，获得用户ID
     *
     * @param CHAR $username
	 *
     * @return $user
     */
	function get_userid($username)
	{
		if(!$this->is_username($username)) return false;
		$sql = "SELECT userid FROM $this->table_cache WHERE username='$username' LIMIT 1";
		$user = $this->db->get_one($sql);
		return $user['userid'];
	}

	/**
	 * 匹配用户名与邮件是否存在
	 *
	 * @param STRING $username
	 * @param STRING $email
	 * @return $user
	 */
	function match_user_email($username, $email)
	{
		$sql = "SELECT userid, groupid FROM $this->table_cache WHERE username='$username' AND email='$email' LIMIT 1";
		$user = $this->db->get_one($sql);
		if(!$user)
		{
			$this->msg = 'username_and_email_not_match';
			return false;
		}
		return $user['userid'];
	}

	/**
	 * 根据用户组获得用户信息
	 *
	 * @param INT $groupid
	 * @return $result
	 */
	function get_by_groupid($groupid, $order = '', $page = 1, $pagesize = 100)
	{
		$array = array();
		$where = " AND groupid='$groupid'";
		$array = $this->listinfo($where,  $order = '', $page, $pagesize);
		return $array;
	}

	/**
	 *获得所有用户的信息
	 */
	function get_all($order = '', $page, $pagesize)
	{
		$array = array();
		$array = $this->listinfo($where,  $order = '', $page, $pagesize);
		return $array;
	}

	function count_model()
	{
		return COUNT($this->MODEL);
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
	function listinfo($where = '', $order = '', $page = 1, $pagesize = 100, $ismore = 1)
	{
		global $AREA, $mod;
		$limit = $result = '';
		if($where) $where = "$where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$array = array();
		$sql = $ismore ? "SELECT * FROM $this->table_cache m, $this->table_info i WHERE m.userid=i.userid $where $order $limit": "SELECT * FROM $this->table_cache $where $order $limit";
		$result = $this->db->query($sql);
		while($r = $this->db->fetch_array($result))
		{
			$r['area'] = $AREA[$r['areaid']];
			if($r['avatar'])
			{
				if(!class_exists('attachment'))
				{
					require 'attachment.class.php';
				}
				$attachment = new attachment($mod);
				$avatar = $attachment->get($r['avatar'], 'filepath');
				$r['avatar'] = UPLOAD_URL.$avatar['filepath'];
			}
			
			$array[] = $r;
		}
      	$this->db->free_result($result);
		return $array;
	}

	function count_member($where = '')
	{
		if($where) $where = " WHERE $where";
		$result = $this->db->get_one("SELECT count(*) as num FROM $this->table_cache $where");
		return $result['num'];
	}

	/**
	 * 用户登录方法
	 *
	 * @param STRING $username
	 * @param CHAR $password
	 * @param INT $cookietime
	 * @return true
	 */
	function login($username, $password, $cookietime = 0)
	{
		if(!$this->is_username($username))
		{
			return false;
		}
		$userid = $this->get_userid($username);
		$r = $this->get($userid, '*', 1);
		if(!$r)
		{
			$this->msg = 'username_not_exist';
			return FALSE;
		}

		$md5_password = $this->password($password);
		if($r['password'] != $md5_password)
		{
			if($r['password'] == substr($md5_password, 8, 16))
			{
				$arr_password = array('password'=>$md5_password);
				$this->db->update($this->table, $arr_password, "userid='$userid'");
				$this->db->update($this->table_cache, $arr_password, "userid='$userid'");
			}
			else
			{
				$this->msg = 'password_not_right';
				return FALSE;
			}
		}
		if($r['groupid'] == 1)
		{
			$_SESSION['admin_groupid'] = $r['groupid'];
		}
		$this->cache_group = cache_read('member_group_'.$r['groupid'].'.php');
		if($r['groupid'] == 5 && !$this->cache_group['allowvisit'])
		{
			$this->msg = 'your_account_is_approvalling';
			return FALSE;
		}
		elseif($r['groupid'] == 4 && !$this->cache_group['allowvisit'])
		{
			$this->msg = 'your_account_not_validate';
			return FALSE;
		}
		elseif($r['groupid'] == 2)
		{
			$this->msg = 'your_account_banned_by_admin';
			return FALSE;
		}
		elseif($r['disabled'])
		{
			$this->msg = 'your_account_banned_by_admin';
			return FALSE;
		}
		if(!$this->cache_group['allowvisit'])
		{
			$this->msg = 'your_account_banned_by_admin';
			return false;
		}
		$this->_userid = $r['userid'];
		if(!$cookietime) $get_cookietime = get_cookie('cookietime');
		$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
		$cookietime = $_cookietime ? TIME + $_cookietime : 0;
		$phpcms_auth_key = md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
		$phpcms_auth = phpcms_auth($this->_userid."\t".$md5_password, 'ENCODE', $phpcms_auth_key);
		set_cookie('auth', $phpcms_auth, $cookietime);
		set_cookie('cookietime', $_cookietime, $cookietime);
		$username = $this->escape($username);
		set_cookie('username', $username, $cookietime);
		$this->db->query("UPDATE $this->table_info SET lastloginip='".IP."',lastlogintime=".TIME.",logintimes=logintimes+1 WHERE userid=$this->_userid");
		require_once PHPCMS_ROOT.'member/include/group.class.php';
		$group = new group();
		$group->extend_update();
		return $r;
	}

	/**
	 * 用户注册检测函数
	 *
	 * @param ARRAY $info
	 * @param ARRAY $moreinfo
	 * @return unknown
	 */
    function register_check($info)
    {
		if(!($this->M['allowregister']))
		{
			$this->msg = 'sorry_new_register_not_allowed';
			return false;
		}
		if(!is_array($info))
		{
			$this->msg = 'username_not_accord_with_critizen';
			return false;
		}
		if(!$this->username_exists($info['username']))
		{
			return false;
		}
		if(!$this->is_username($info['username']))
		{
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
		if($info['modelid'] && !isset($this->MODEL[$info['modelid']]))
		{
			$this->msg = 'modelid_not_exists';
			return false;
		}
		if($this->email_exists($info['email']))
		{
			return false;
		}
		if($this->M['enableQchk'])
		{
			if(empty($info['question']))
			{
				$this->msg = 'password_clue_answer_not_null';
				return false;
			}
			elseif (empty($info['answer']))
			{
				$this->msg = 'password_clue_question_not_null';
				return false;
			}
		}
						
        return true;
    }

	/**
	 * 注册方法
	 *
	 * @param ARRAY $info
	 * @param ARRAY $moreinfo
	 * @return INT用户ID
	 */
	function register($memberinfo = ARRAY())
	{
		global $MODULE;
        if(!$this->register_check($memberinfo)) return false;
		$memberinfo['password'] = $this->password($memberinfo['password']);
		$memberinfo['groupid'] = $this->M['enablemailcheck'] ? 4 : ($this->M['enableadmincheck'] ? 5 : 6);
		if($memberinfo['groupid'] == 6)
		{
			$this->msg = 'registered_success_login_please';
		}
		elseif($memberinfo['groupid'] == 5)
		{
			$this->msg = 'profile_post_success_waiting_verify';
		}
		elseif ($memberinfo['groupid'] == 4)
		{
			$this->msg = 'profile_post_success';
		}
		$memberinfo['regip'] = IP;
		$memberinfo['regtime'] = TIME;
		$memberinfo['answer'] = md5($memberinfo['answer']);
		$member_fields = array('username','password','email','groupid','areaid','amount','point','modelid');
		$member_info_fields = $this->db->get_fields($this->table_info);
        foreach($memberinfo as $field=>$val)
        {
			if(in_array($field, $member_fields))
			{
				$info[$field] = $val;
			}
			if(in_array($field, $member_info_fields))
			{
				$moreinfo[$field] = $val;
			}
		}
		unset($memberinfo);
        $this->db->insert($this->table, $info);
        $moreinfo['userid'] = $info['userid'] = $userid = $this->db->insert_id();
		$arr_model = array('userid'=>$userid);
		$this->edit_model($info['modelid'], $arr_model);
        $this->db->insert($this->table_cache, $info);
        $this->db->insert($this->table_info, $moreinfo);
		if(isset($MODULE['pay']))
		{
			$pay_api = load('pay_api.class.php', 'pay', 'api');
			if($this->M['defualtamount'] > 0.01)
			{		
				$pay_api->update_exchange('member', 'amount', $this->M['defualtamount'], '注册赠送金钱', $userid);
			}
			if($this->M['defualtpoint'])
			{
				$pay_api->update_exchange('member', 'point', $this->M['defualtpoint'], '注册赠送积分', $userid);
			}
		}
		else
		{
			if($this->M['defualtamount'])
			{
				$this->db->update($this->table, array('amount'=>$this->M['defualtamount']), "userid='$userid'");
				$this->db->update($this->table_cache, array('amount'=>$this->M['defualtamount']), "userid='$userid'");
			}
			if($this->M['defualtpoint'])
			{
				$this->db->update($this->table, array('point'=>$this->M['defualtpoint']), "userid='$userid'");
				$this->db->update($this->table_cache, array('point'=>$this->M['defualtpoint']), "userid='$userid'");
			}
		}
		return $userid;
	}

    /**
     * 修改用户信息
     *
     * @param ARRAY $info
     * @param ARRAY $moreinfo
	 *
     * @return $userid
     */
	function edit($memberinfo)
	{
		global $_userid;
		$userid = $_userid;
		if($userid < 1) return false;
		$member_fields = array('username', 'email', 'message', 'areaid');
		$member_info_fields = array('question','answer','avatar', 'actortype');
		if($member_fields['username']) $this->is_username($memberinfo['username']);
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
			$this->db->update($this->table, $info, "userid='$userid'");
			$this->db->update($this->table_cache, $info, "userid='$userid'");
		}
		if(is_array($moreinfo))
		{
			$this->db->update($this->table_info, $moreinfo, "userid='$userid'");
		}
		return $userid;
	}

	function edit_answer($question, $answer, $password)
	{
		global $_userid;
		$userid = intval($_userid);
		if($userid < 1) return false;
		$r = $this->db->get_one("SELECT userid FROM $this->table_cache WHERE userid=$userid AND password='".$this->password($password)."'");
        if(!$r)
		{
			$this->msg = 'original_password_not_correct';			
			return false;
		}
		$answer = md5($answer);
		$answerinfo = array('question'=>$question, 'answer'=>$answer);
		return $this->db->update($this->table_info, $answerinfo, "userid=$userid");
	}

	function edit_model($modelid, $modelinfo)
	{
		$modelid = intval($modelid);
		if($modelid < 1 || !isset($this->MODEL[$modelid])) return false;
		$userid = intval($modelinfo['userid']);
		if($userid < 1) return false;
		$tablename = DB_PRE.'member_'.$this->MODEL[$modelid]['tablename'];
		if(!$tablename) return false;
		$result = $this->db->get_one("SELECT userid FROM $tablename WHERE userid=$userid");
		if($result)
		{
			$sql_value = '';
			foreach($modelinfo as $k=>$v)
			{
				$sql_value .= ", b.`$k`='$v'";
			}
			$sql_value = substr($sql_value, 1);
			$sql = "UPDATE `$this->table_cache` c, `$tablename` b SET $sql_value WHERE c.userid=b.userid AND b.userid='$userid'";
			return $this->db->query($sql);
		}
		else
		{
			return $this->db->update($tablename, $modelinfo);
		}		
	}

	/**
	 * 根据用户ID删除用户信息
	 *
	 * @param INT $userids
	 * @return true
	 */
	function delete($arruserid)
	{
		if(is_array($arruserid))
		{
			array_map(array(&$this, 'delete'), $arruserid);
		}
		else
		{
			$userid = intval($arruserid);
			$modelid = $this->get($userid, 'modelid');
			$modelid = $modelid['modelid'];
			$tablename = DB_PRE.'member_'.$this->MODEL[$modelid]['tablename'];
			$this->db->query("DELETE `$tablename` FROM `$tablename`, `$this->table_cache` WHERE `$tablename`.userid=`$this->table_cache`.userid AND `$tablename`.userid='$userid'");
			$this->db->query("DELETE `$this->table`, `$this->table_cache`, `$this->table_info` FROM `$this->table`, `$this->table_cache`, `$this->table_info` WHERE `$this->table`.userid=`$this->table_cache`.userid AND `$this->table_info`.userid=`$this->table_cache`.userid AND `$this->table`.userid=`$this->table_info`.userid AND `$this->table_cache`.userid='$userid'");
			$this->db->query("DELETE FROM $this->table_admin WHERE userid=$userid");
		}
		return true;
	}

	/**
	 * 用户退出方法
	 *
	 * @return TRUE
	 */
	function logout()
	{
		set_cookie('auth', '');
		set_cookie('username', '');
		unset($_SESSION);
		return true;
	}

	function verify_answer($userid, $question ,$anwser)
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		$anwser = md5($anwser);
		$result = $this->get($userid, 'question, answer, email', 1);
		if(($result['question'] != $question) || ($result['answer'] != $anwser))
		{
			$this->msg = 'password_clue_answer_not_right';
			return false;
		}
		return $result['email'];
	}

	function get_fields($modelid)
	{
		$modelid = intval($modelid);
		if($modelid < 1) return false;
		$fields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
		return $fields;
	}

	/**
	 * 设置用户密码
	 *
	 * @param STRING $oldpassword
	 * @param STRING $new_password
	 * @return unknown
	 */
	function set_password($old_password, $new_password)
	{
		global $_userid;
		$this->_userid = $_userid;
		$userid = $this->_userid;
		if($userid < 1) return false;
		if(!$this->is_password($new_password))
		{
			$this->msg = 'password_not_less_than_3_longer_than_20';
			return false;
		}
        $r = $this->db->get_one("SELECT userid FROM $this->table_cache WHERE userid='$userid' AND password='".$this->password($old_password)."'");
        if(!$r)
		{
			$this->msg = 'original_password_not_correct';			
			return false;
		}
		$password = $this->password($new_password);
		$arr_password = array('password'=>$password);
		$this->db->update($this->table, $arr_password, "userid='$userid'");
		return $this->db->update($this->table_cache, $arr_password, "userid='$userid'");
	}

	function verfy_password($userid, $password)
	{
		$userid = intval($userid);
		return $this->db->get_one("SELECT userid FROM $this->table_cache WHERE userid='$userid' AND password='".$this->password($password)."'");
	}

	function edit_password($userid, $password)
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		if(!$this->is_password($password))
		{
			$this->msg = 'password_not_less_than_3_longer_than_20';
			return false;
		}
		$password = $this->password($password);
		$sql = "UPDATE `$this->table_cache` c, `$this->table` m SET c.`password`='$password', m.`password`='$password' WHERE c.userid=m.userid AND c.userid='$userid'";
		return $this->db->query($sql);
	}
	
	function edit_password_username($username, $password)
	{
		if(!$this->is_password($password))
		{
			$this->msg = 'password_not_less_than_3_longer_than_20';
			return false;
		}
		$password = $this->password($password);
		$sql = "UPDATE `$this->table_cache` c, `$this->table` m SET c.`password`='$password', m.`password`='$password' WHERE c.username=m.username AND c.username='$username'";
		return $this->db->query($sql);
	}

    /**
     * 设置用户金钱
     *
     * @param string $amount
     * @return  TRUE
     */
	function set_amount($userid, $amount)
	{
		$amount = round(floatval($amount), 2);
		if($amount < 0) return false;
		return $this->db->query("UPDATE $this->table SET amount='$amount' WHERE userid='$userid'");
	}

	/**
	 * 提供加密字符串函数
	 *
	 * 2008年6月24日修改
	 * @param ARRAY $info
	 * @return unknown
	 */
	function make_authcode($info)
	{
		if(!isset($info['username'])) return false;
		
		$userid = $this->get_userid($info['username']);
		if(!isset($info['regtime'])) $info = $this->get($userid, 'm.username, i.regtime', 1);
		$authcode = md5(AUTH_KEY.$info['username'].$info['regtime']);
		return $authcode;
	}

	/**
	 * 验证确认码是否正确
	 *
	 * @param unknown_type $authcode
	 * @return unknown
	 */
	function verify_authcode($userid, $authcode)
	{
		if(!$this->match_authcode($userid, $authcode))
		{
			return false;
		}
		$info = $this->get($useid, 'groupid');
		if($info['groupid'] == 6)
		{
			$this->msg = 'user_is_actived';
			return false;
		}
		$groupid = $this->M['enableadmincheck'] ? 5 : 6;
		$update = array('groupid'=>$groupid);
		$where = 'userid='.$userid;
		$this->db->update($this->table, $update, $where);
		$this->db->update($this->table_cache, $update, $where);
		return true;
	}

	function match_authcode($userid, $authcode)
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		$authcode = trim($authcode);
		if(strlen($authcode) != 32)
		{
			
			$this->msg = 'verify_string_not_correct';
			return false;
		}
		$info = $this->get($userid, 'm.username, i.regtime', 1);
		$verify_authcode = md5(AUTH_KEY.$info['username'].$info['regtime']);
		if($authcode != $verify_authcode)
		{
			$this->msg = 'authcode_is_illegal';
			return false;
		}
		return true;
	}

	/**
	 * 检查用户名是否存在
	 *
	 * @param STRING $username
	 *
	 * @return $username
	 */
	function username_exists($username, $userid='')
	{
		if(!isset($username) && empty($username))
		{
			return false;
		}
		$result = $this->db->get_one("SELECT userid FROM $this->table_cache WHERE username='$username' AND userid!='$userid'");
		if($result)
		{
			$this->msg = 'have_registered';
			return false;
		}
		return $username;
	}

	/**
	 * 检查邮件是否存在
	 *
	 * @param STRING $email
	 *
	 * @return $email
	 */
	function email_exists($email, $userid = '')
	{
		$result = $this->db->get_one("SELECT userid FROM $this->table_cache WHERE email='$email' AND userid!='$userid'");
		if($result)
		{
			$this->msg = 'have_used_change_one_email';
			return true;
		}
		return false;
	}

	/**
	 * 按照某条件检查用户是否存在
	 *
	 * @param unknown_type $field
	 * @param unknown_type $value
	 * @return unknown
	 */
	function _exists($field, $value)
	{
		return $this->db->get_one("SELECT userid FROM $this->table_cache WHERE $field='$value' LIMIT 0, 1");
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
		if($this->is_badword($username) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username))
		{
			$this->msg = 'username_not_accord_with_critizen';
			return false;
		}
		elseif ( 20 <= $strlen || $strlen < 2 )
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

    /**
	 * 检查密码长度是否符合规定
	 *
	 * @param STRING $password
	 * @return 	TRUE or FALSE
	 */
	function is_password($password)
	{
		$strlen = strlen($password);
		if($strlen >= 4 && $strlen <= 20) return true;
		return false;
	}

	/**
	 * 对用户的秘码进行加密
	 *
	 * @param unknown_type $password
	 * @return unknown
	 */
	function password($password)
	{
		return md5(PASSWORD_KEY.$password);
	}

	/**
	 * 根据model的ID获得信息
	 *
	 * @param STRING $fields
	 * @param STRING $tablename
	 * @return ARRAY用户表信息
	 */
	function get_model_info($userid, $modelid = '', $fields = '*')
	{
		global $_userid;
		$userid = empty($userid) ? $_userid : intval($userid);
		if($userid < 1) return false;
		if($modelid)
		{
			$modelid = intval($modelid);
		}
		else
		{
			$model_info = $this->db->get_one("SELECT modelid FROM $this->table_cache WHERE userid='$userid'");
			$modelid = $model_info['modelid'];
		}
		if($modelid < 1) return false;
		$modelfields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
		$tablename = DB_PRE.'member_'.$this->MODEL[$modelid]['tablename'];
		if(empty($tablename)) return false;
		$data = $this->db->get_one("SELECT $fields FROM $tablename WHERE userid='$userid'");
		$info = array();
		foreach($modelfields as $key=>$value)
		{
			$info[$key] = $data[$key];
		}
		return $info;
	}

	function msg()
	{
		global $LANG;
		return $LANG[$this->msg];
	}

    function update_credits($credit,$userid=0)
	{
        global $_point,$_userid;
        $userid=$userid?$userid:$_userid;
        $_point =$_point+intval($credit);
        $this->db->query("update $this->table_cache set point='$_point' where userid='$userid'");
        $this->db->query("update $this->table set point='$_point' where userid='$userid'");
		return true;
    }

	function is_alloweditpassword($userid)
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		$r = $this->db->get_one("SELECT alloweditpassword FROM $this->table_admin WHERE userid='$userid'");
		return $r ? $r['alloweditpassword'] : 0;
	}

	function escape($str)
	{
		if(strtolower(CHARSET)=='gbk')
		{
			preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$r);
			$ar = $r[0];  
			foreach($ar as $k=>$v)
			{
			  if(ord($v[0]) < 128)
				  $ar[$k] = rawurlencode($v);
			  else
				  $ar[$k] = "%u".bin2hex(iconv(CHARSET,"UCS-2",$v));
			}  
			return join("",$ar);
		}
		else
		{
			preg_match_all("/[\xc2-\xdf][\x80-\xbf]+|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}|[\x01-\x7f]+/e",$str,$r);
			$str = $r[0];
			$len = count($str);
			for($i=0; $i<$len; $i++) {
				$value = ord($str[$i][0]);
				if($value < 223){
					$str[$i] = rawurlencode(utf8_decode($str[$i]));
				} else {
				$str[$i] = "%u".strtoupper(bin2hex(iconv("UTF-8","UCS-2",$str[$i])));
				}
			}
			return join("",$str);

		}
	}
}
?>