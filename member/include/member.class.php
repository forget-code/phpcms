<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$errormsgs = array('user_not_exists'=>$LANG['username_not_exist'], 'password_is_wrong'=>$LANG['password_not_right'], 'user_is_locked'=>$LANG['your_account_banned_by_admin'], 'user_is_verify'=>$LANG['your_account_not_validate'], 'user_is_checking'=>$LANG['your_account_is_approvalling']);

class member
{
	var $username = '';
	var $db;
	var $errormsg;

    function member($username = '')
	{
		global $db;
		$this->db = &$db;
        $this->set_username($username);
        register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
	}

	function set_username($username)
	{
		if($this->is_badword($username)) return FALSE;
		$this->username = $username;
		return TRUE;
	}

	function get_info()
	{
        return $this->db->get_one("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid and username='$this->username' limit 0,1");
	}

	function is_reg($username)
	{
		return $this->db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$username' limit 0,1");
	}

	function ban_name($username)
	{
		global $MOD;
		if(!$MOD['banname']) return FALSE;
		$bannames = explode(',', $MOD['banname']);
		foreach($bannames as $banname)
		{
			if(strpos($username, $banname)!==FALSE) return TRUE;
		}
		return FALSE;
	}

	function login($login_password, $login_cookietime = 0, $forward = '')
	{
		global $PHPCMS,$PHP_TIME,$PHP_IP,$LANG;

		$info = $this->get_info();
		if(!$info) 
		{
			$this->errormsg = 'user_not_exists';
			return FALSE;
		}

		@extract($info);

		if($password != md5($login_password))
		{
			$this->errormsg = 'password_is_wrong';
			return FALSE;
		}

		if($groupid == 2)
		{
			$this->errormsg = 'user_is_locked';
			return FALSE;
		}
		elseif($groupid == 4)
		{
			$this->errormsg = 'user_is_verify';
			return FALSE;
		}
		elseif($groupid == 5)
		{
			$this->errormsg = 'user_is_checking';
			return FALSE;
		}

		$_cookietime = $login_cookietime ? intval($login_cookietime) : (getcookie('cookietime') ? getcookie('cookietime') : 0);
		$cookietime = $_cookietime ? $PHP_TIME + $_cookietime : 0;
		$phpcms_auth_key = md5($PHPCMS['authkey'].$_SERVER['HTTP_USER_AGENT']);
		$phpcms_auth = phpcms_auth($userid."\t".$password."\t".$answer, 'ENCODE', $phpcms_auth_key);
		mkcookie('auth', $phpcms_auth, $cookietime);
		mkcookie('cookietime', $_cookietime, $cookietime);
		
		$this->db->query("UPDATE ".TABLE_MEMBER." SET lastloginip='$PHP_IP',lastlogintime=$PHP_TIME,logintimes=logintimes+1 WHERE username='$this->username'");
		
		if($forward) showmessage($LANG['login_success'], $forward);
		return $info;
	}

	function logout($forward = '')
	{
		global $LANG;
		mkcookie('auth', '');
		unset($_SESSION['admin_grade'], $_SESSION['admin_modules'], $_SESSION['admin_channelids'], $_SESSION['admin_purviewids'], $_SESSION['admin_catids'], $_SESSION['admin_specialids']);
		if($forward) showmessage($LANG['logout_success'], $forward);
		return TRUE;
	}

	function register($memberinfo)
	{
		global $PHPCMS,$PHP_TIME,$PHP_IP;

		if(!is_array($memberinfo) || !$this->set_username($memberinfo['username']) || !is_email($memberinfo['email'])) return FALSE;
        
		$memberinfo = new_htmlspecialchars($memberinfo);
		$memberinfo['password'] = md5($memberinfo['password']);
		$memberinfo['answer'] = md5($memberinfo['answer']);

		$table_member_fields = array('username','password','question','answer','email','showemail','groupid','arrgroupid','chargetype','point','begindate','enddate');
		$table_member_info_fields = array('truename','gender','birthday','idtype','idcard','province','city','area','industry','edulevel','occupation','income','telephone','mobile','address','postid','homepage','qq','msn','icq','skype','alipay','paypal','userface','facewidth','faceheight','sign');
		$member_sql1 = $member_sql2 = $member_info_sql1 = $member_info_sql2 = '';
		foreach($memberinfo as $k=>$v)
		{
			if(in_array($k, $table_member_fields))
			{
				$member_sql1 .= ','.$k;
				$member_sql2 .= ",'$v'";
			}
			elseif(in_array($k, $table_member_info_fields))
			{
				$member_info_sql1 .= ','.$k;
				$member_info_sql2 .= ",'$v'";
			}
		}
        $member_sql1 = substr($member_sql1, 1);
        $member_sql2 = substr($member_sql2, 1);
        $member_info_sql1 = substr($member_info_sql1, 1);
        $member_info_sql2 = substr($member_info_sql2, 1);

		$this->db->query("INSERT INTO ".TABLE_MEMBER."($member_sql1,regip,regtime) values($member_sql2,'$PHP_IP','$PHP_TIME')");
		$userid = $this->db->insert_id();
	    $this->db->query("INSERT INTO ".TABLE_MEMBER_INFO."(userid, $member_info_sql1) values('$userid', $member_info_sql2)");
		return $userid;
	}

	function edit($memberinfo)
	{
        global $_userid;
		if(!is_array($memberinfo) || !is_email($memberinfo['email']) || !$_userid) return FALSE;
        
		$memberinfo = new_htmlspecialchars($memberinfo);

		$table_member_fields = array('email','showemail','chargetype','point','begindate','enddate');
		$table_member_info_fields = array('truename','gender','birthday','idtype','idcard','province','city','area','industry','edulevel','occupation','income','telephone','mobile','address','postid','homepage','qq','msn','icq','skype','alipay','paypal','userface','facewidth','faceheight','sign');
		$member_sql = $member_info_sql = '';
		foreach($memberinfo as $k=>$v)
		{
			if(in_array($k, $table_member_fields))
			{
                $member_sql .= ",$k='$v'";
			}
			elseif(in_array($k, $table_member_info_fields))
			{
				$member_info_sql .= ",$k='$v'";
			}
		}
        $member_sql = substr($member_sql, 1);
        $member_info_sql = substr($member_info_sql, 1);

	    $this->db->query("UPDATE ".TABLE_MEMBER." SET $member_sql WHERE userid=$_userid");
	    $this->db->query("UPDATE ".TABLE_MEMBER_INFO." SET $member_info_sql WHERE userid=$_userid");
		
		return $this->db->affected_rows();
	}

    function editpassword($oldpassword, $password)
    {
        global $_userid;
        if(empty($oldpassword) || empty($password) || !$_userid) return FALSE;

        $info = $this->db->get_one("SELECT password FROM ".TABLE_MEMBER." WHERE userid=$_userid");

        if(md5($oldpassword) != $info['password']) return FALSE;

        $password = md5($password);
	    $this->db->query("UPDATE ".TABLE_MEMBER." SET password='$password' WHERE userid=$_userid");
		return $this->db->affected_rows();
    }

	function group($groupid = 0)
	{
        return $this->db->get_one("SELECT * FROM ".TABLE_MEMBER_GROUP." WHERE groupid=$groupid limit 0,1");
	}

	function set_group($username, $groupid)
	{
        global $_username;
		if(!$username) $username = $_username;
		$groupid = intval($groupid);
	    $this->db->query("UPDATE ".TABLE_MEMBER." SET groupid=$groupid WHERE username='$username'");
		return $this->db->affected_rows();
	}

	function make_authstr($username)
	{
		$authstr = random(32, 'abcdefghjklmnopqrstxyzuvwi0123456789');
	    $this->db->query("UPDATE ".TABLE_MEMBER." SET authstr='$authstr' WHERE username='$username'");
		return $authstr;
	}

	function check_authstr($username, $authstr)
	{
        $authstr = trim($authstr);
		if(!$username || !$authstr) return FALSE;
        $r = $this->db->get_one("SELECT authstr FROM ".TABLE_MEMBER." WHERE username='$username'");
		return $authstr == $r['authstr'];
	}

	function email_exists($email)
	{
		return $this->db->get_one("SELECT email FROM ".TABLE_MEMBER." WHERE email='$email' limit 0,1");
	}

	function exists()
	{
		return $this->db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$this->username' limit 0,1");
	}

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

	function errormsg()
	{
		global $errormsgs;
		return $errormsgs[$this->errormsg];
	}
}
?>