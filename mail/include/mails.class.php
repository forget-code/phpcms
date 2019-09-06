<?php
class mails
{
	var $db;
	var $email_type_table = '';
	var $email_table = '';
    var $m = '';
    function __construct()
	{
		$this->mails();
	}
	function mails()
	{
		global $db;
		$this->table_email = DB_PRE.'mail_email';
		$this->db = $db;
		$this->table_email_type = DB_PRE.'mail_email_type';
        $this->m = load('sendmail.class.php');
	}

	function add($email, $typeids)
	{
        global $_userid, $_username;
        if(!is_email($email))
		{
			$this->error = 0;
			return false;
		}
        if(!is_array($typeids))
		{
			$this->error = 1;
			return false;
		}
        $username   = trim($_username);
        $userid     = trim($_userid);
        foreach($typeids as $typeid)
        {
            $typeid = intval($typeid);
            $this->db->query("INSERT INTO `$this->table_email_type` (`email`, `typeid`) VALUES('$email','$typeid')");
        }
        return true;
	}

    //游客订阅，退订
    function send($email, $typeids, $flag = 0)
    {
	    global $MODULE;
        if(!is_email($email))
		{
			$this->error = 0;
			return false;
		}
        if(!is_array($typeids))
		{
			$this->error = 1;
			return false;
		}
        $tm = TIME;
        $tp = implode(",", $typeids);
        $auth = md5(AUTH_KEY.$email.$flag.$tp.$tm);
        $content = '请点击下面的连接或直接复制该连接到浏览器中激活订阅或退订</br>';
        $url = $MODULE['mail']['url'].'auth.php?tp='.$tp.'&em='.$email.'&auth='.$auth.'&tm='.$tm;
        if($flag) $url .= '&ac=check'; else $content .= '&ac=del'; //ac=0 退订
        $content .= "<a target=\"_blank\" href=".$url.">".$url."</a>";
        $title = '订阅确认';
        $this->m->send($email, $title, $content,$PHPCMS['mail_user']);
        return true;
    }

    function getTypes($mail)
    {
        $row = $this->db->get_one("SELECT * FROM `$this->table_email` WHERE `email` ='{$mail}'");
        $ids = explode(",", $row['typeids']);
        return $ids;
    }

    function checkMailType($mail, $types)
    {
        $ids = explode(",",$types);
        if($this->check_mail($mail,1))
        {
            foreach($ids AS $k)
            {
                $this->seachMailTpye($mail, $k);
            }
        }
    }
    function delTpyeMail($mail, $types)
    {
        $ids = explode(",",$types);
        if($this->check_mail($mail,1))
        {
            foreach($ids AS $k)
            {
                $this->seachMailTpye($mail, $k,1);
            }
        }
    }
    function seachMailTpye($mail, $typeid,$flag = '')
    {
        $row = $this->db->get_one("SELECT * FROM `$this->table_email_type` WHERE `email` ='{$mail}' AND `typeid` = '{$typeid}' ");
        if($flag)
        {
            if(!empty($row))
                $this->db->query("DELETE FROM `$this->table_email_type` WHERE `email` ='{$mail}' AND `typeid` = '{$typeid}'");
        }
        else
        {
            if(empty($row))
            {
                $sql = "INSERT INTO `$this->table_email_type` (`email`, `typeid`) VALUES('$mail','$typeid')";
                $this->db->query($sql);
            }
        }
    }
    function delMailType($mail, $types)
    {
        $ids = explode(",",$types);
        if($this->check_mail($mail))
        {
            foreach($ids AS $k)
            {
                $this->seachMailTpye($mail, $k,1);
            }
        }
    }
//------游客订阅，退订处理

    function drop($email, $typeids)
	{
        global $_userid;
		if(!is_email($email))
		{
			$this->error = 0;
			return false;
		}
		if(!empty($typeids))
		{
            $userid = intval($_userid);
			$in = $this->db_create_in($typeids);
			$sql = "DELETE FROM `$this->table_email_type` WHERE `email` ='{$email}' AND `typeid` NOT {$in} ";//AND `userid` = '{$userid}'
		}
		else
		{
			$sql = "DELETE FROM `$this->table_email_type` WHERE `email` ='{$email}' ";
		}
		return $this->db->query($sql);
	}

    function del($delmail)
    {
        if(!is_email($delmail)) return false;
        if($this->db->query("DELETE FROM `$this->table_email` WHERE `email` ='$delmail' ADN `userid` = '0'"))
        {
            return $this->db->query("DELETE FROM `$this->table_email_type` WHERE `email` ='$delmail'");
        }
    }

	function get_types($email)
	{
		$sql = "SELECT `typeid` FROM $this->table_email_type WHERE `email` = '{$email}'";
		$result = $this->db->query($sql);
		$types = array();
		while($r = $this->db->fetch_array($result))
		{
			$types[$r['typeid']] = $r['typeid'];
		}
		return $types;
	}

	function get_mail()
	{
		global $_userid;
		$userid = intval($_userid);
		$sql = "SELECT `email`,`status` FROM `$this->table_email` WHERE `userid` = '{$userid}'";
		return $this->db->get_one($sql);
	}

	function replace_mail( $newmail = '', $oldmail)
	{
		global $_userid, $_username, $M;
		$userid = intval($_userid);
		if(!empty($newmail))
		{
			if(!is_email($newmail) || !is_email($oldmail))
			{
                if(!$this->check_mail($email))
                {
                    $this->error = 2;
                    return false;
                }
				$this->error = 0;
				return false;
			}
			else
			{
				$sql = "UPDATE `$this->table_email` SET `email` = '{$oldmail}' WHERE `userid` = '{$userid}'";
				if ( $this->db->query($sql) )
				{
					$sql = "UPDATE `$this->table_email_type` SET `email` = '{$oldmail}' WHERE `email` = '{$newmail}' ";
					return $this->db->query($sql);
				}
			}
		}
		else
		{
			if (!is_email($oldmail))
			{
				$this->error = 0;
				return false;
			}
			else
			{
				if ($M['validation']){ $status = '0';}else{$status = '1';}
				$ip = IP; $time = TIME;
				$sql = "INSERT INTO `$this->table_email` (`email`, `userid`, `username`, `ip`, `addtime`, `status`) VALUES('$oldmail','$userid', '$_username', '$ip', '$time', '$status')";
				return $this->db->query($sql);
			}
		}
	}

    function check_mail($email, $flag='')
    {
		global $_userid;
		if(!defined('IN_ADMIN')) $sql = " AND userid='$_userid' or userid=0";
        $row = $this->db->get_one("SELECT `email` FROM `$this->table_email` WHERE `email` = '$email' $sql");
        if(empty($row['email']))
        {
            if($flag)
            {
                $username = '游客';
                $userid = $status= 0;
                $ip = IP;
				$time = TIME;
				$status = 1;
                $sql = "INSERT INTO `$this->table_email` (`email`, `userid`, `username`, `ip`, `addtime`, `status`, `authcode`) VALUES('$email','$userid', '$username', '$ip', '$time', '$status', '$authcode')";
                $this->db->query($sql);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }
    //删除用户所有的邮箱订阅
    function myType()
    {
        $mod = "mail";
        $input = "";
        $types = subtype($mod);
        $i = 1;
        $ids = $this->getTypeMail();
        foreach($ids AS $k => $v)
        {
            $checked =  'checked' ;
            $input .= "<span style=\"width: 100px;\">\n<input type=\"checkbox\"  style=\"{$v[style]}\" name=\"typeid[]\" id=\"typeid\" value=\"{$k}\" {$checked} class=\"checkbox_style\"/> {$types[$k][name]}</span> ";
            if($i%5 == 0) $input .= "<br />\n";
            $i++;
        }
        $input .= "\n";
        return $input;
    }
    function dropAll($email, $auth='')
    {
        if($this->check_mail($email))
        {
            $row = $this->db->get_one("SELECT * FROM `$this->table_email_type` WHERE `email` ='$email' ");
            if(empty($row))
            {
                $sql = "DELETE FROM `$this->table_email` WHERE `email` ='{$email}' ";
                $this->db->query($sql);
            }
            elseif($this->db->query("DELETE FROM `$this->table_email_type` WHERE `email` ='$email' "))
            {
                $sql = "DELETE FROM `$this->table_email` WHERE `email` ='{$email}' ";
                return $this->db->query($sql);
            }
        }
        else
        {
            $this->error = 4;
            return false;
        }
    }
    //删除 用户订阅的类型
    function dropType($email)
    {
        $sql = "DELETE FROM `$this->table_email_type` WHERE `email` ='{$email}' ";
        return $this->db->query($sql);
    }
    function getTypeMail()
    {
        global $_userid;
        $userid = intval($_userid);
        $sql = "SELECT b.typeid FROM `$this->table_email` AS a INNER JOIN `$this->table_email_type` AS b ON a.email = b.email WHERE a.userid = '{$userid}'";
        $result = $this->db->query($sql);
        $types = array();
        while($r = $this->db->fetch_array($result))
		{
			$types[$r['typeid']] = $r['typeid'];
		}
        return $types;
    }
    //创建 邮箱类型表单
    function creatInput()
    {
        $mod = "mail";
        $input = "";
        $types = subtype($mod);
        if(empty($types))
        {
            $input .= '暂时没有订阅类型';
        }
        else
        {
            $i = 1;
            foreach($types AS $k => $v)
            {
                $checked = ($types && in_array($k, $this->getTypeMail())) ? 'checked' : '';
                $input .= "<span style=\"width: 100px;\">\n<input type=\"checkbox\"  style=\"{$v[style]}\" name=\"typeid[]\" id=\"typeid\" value=\"{$k}\" {$checked} class=\"checkbox_style\"/> {$v[name]}</span> ";
                if($i%5 == 0) $input .= "<br />\n";
			    $i++;
            }
        }
        $input .= "\n";
        return $input;
    }
    //用户更新订阅类型
    function setTypeMail($email, $typeids)
    {
        $email = trim($email);
        if(is_email($email))
        {
            if($this->dropType($email))
            {
                if(!empty($typeids))
                {
                    foreach($typeids AS $v)
                    {
                        $sql = "INSERT INTO `$this->table_email_type` (`email`, `typeid`) VALUES('$email','$v')";
                        $this->db->query($sql);
                    }
                }
                return true;
            }
        }
    }

    function addTypeMail($email, $newemail, $typeids)
    {
        global $_userid, $_username, $_email, $PHPCMS;
        $newemail = trim($newemail);
        $email = trim($email);
        if(!$this->check_mail($email))
        {
            $userid = trim($_userid);
            $username = trim($_username);
            $ip = IP;
            $time = TIME;
            $status = 1;
            $sql = "INSERT INTO `$this->table_email` (`email`, `userid`, `username`, `ip`, `addtime`, `status`, `authcode`) VALUES('$email','$userid', '$username', '$ip', '$time', '$status', '$auth')";
            $this->db->query($sql);
        }

        if($this->setTypeMail($email, $typeids))
        {
            if($email != $newemail)
            {
                //newemail
                if($this->check_mail($newemail))
                {
                    $this->error = 8;
                    return false;
                }
                $tm = TIME;
                $auth = md5(AUTH_KEY.$email.$newemail);
                $url = SITE_URL.'mail/auth.php?ac=activate&em='.$newemail.'&om='.$email.'&auth='.$auth.'&tm='.$tm;
                $content = '请点击下面的连接或直接复制该连接到浏览器中激活你的邮箱，,此连接72小时后失效</br>';
                $content .= "<a target=\"_blank\" href=".$url.">".$url."</a>";
                $title = '邮箱激活确认';
                $sql = "UPDATE `$this->table_email` SET `authcode` = '$auth' WHERE `email` = '{$email}'";
                if($this->db->query($sql))
                {
                    $this->m->send($newemail, $title, $content, $PHPCMS['mail_user']);
                    $this->error = 6;
                    return false;
                }
            }
            else
            {
                return true;
            }
        }
    }

    function sendActivation($email)
    {
        global $_userid, $_username,$PHPCMS;
        $userid = trim($_userid);
        $username = trim($_username);
        $tm = $time = TIME;
        $auth = md5(AUTH_KEY.$email);
        $url = SITE_URL.'mail/auth.php?ac=activate&em='.$email.'&auth='.$auth.'&tm='.$tm;
        $content = '请点击下面的连接或直接复制该连接到浏览器中激活你的邮箱,此连接72小时后失效</br>';
        $content .= "<a target=\"_blank\" href=".$url.">".$url."</a>";
        $title = '邮箱激活确认';
        $status = '0';
        $ip = IP;
        $status = 0;
        $sql = "INSERT INTO `$this->table_email` (`email`, `userid`, `username`, `ip`, `addtime`, `status`, `authcode`) VALUES('$email','$userid', '$username', '$ip', '$time', '$status', '$auth')";
        if($this->db->query($sql))
        {
            $this->m->send($email, $title, $content,$PHPCMS['mail_user']);
            return true;
        }
    }
    function setActivation($email, $newemail,$auth)
    {
        $email = trim($email);
        $newemail = trim($newemail);
        $auth = trim($auth);
        if(is_email($email) && is_email($newemail))
        {
            $md5 = md5(AUTH_KEY.$newemail.$email);
            if($md5 == $auth)
            {
                $sql = "SELECT * FROM `$this->table_email` WHERE `email` = '{$newemail}' AND `authcode` = '{$auth}' ";
                $row = $this->db->get_one($sql);
                if(!empty($row))
                {
                    $sql = "UPDATE `$this->table_email` SET `email` = '{$email}',`authcode` = '' WHERE `email` = '{$newemail}' ";
                    if($this->db->query($sql))
                    {
                        $sql = "UPDATE `$this->table_email_type` SET `email` = '{$email}' WHERE `email` = '{$newemail}' ";
					    if($this->db->query($sql))
                        {
                            return true;
                        }
                    }
                }
                else
                {
                    $this->error = 5;
                    return false;
                }
            }
            else
            {
                $this->error = 7;
                return false;
            }
        }
    }
	function db_create_in( $item_list, $field_name = "" )
	{
		if ( empty( $item_list ) )
		{
			return $field_name." IN ('') ";
		}
		else
		{
			if ( !is_array( $item_list ) )
			{
				$item_list = explode( ",", str_replace( "'", "", $item_list ) );
			}
			$item_list = array_unique( $item_list );
			$item_list_tmp = "";
			foreach ( $item_list as $item )
			{
				if ( $item !== "" )
				{
					$item_list_tmp .= $item_list_tmp ? ",'{$item}'" : "'{$item}'";
				}
			}
			if ( empty( $item_list_tmp ) )
			{
				return $field_name." IN ('') ";
			}
			else
			{
				return $field_name." IN (".$item_list_tmp.") ";
			}
		}
	}

	function error()
	{
		$ERRORMSG = array(0 => 'E-mail格式不正确',
			              1 => '请选择订阅类别',
                          2 => '邮箱已经订阅',
                          3 => '你已经订阅过',
                          4 => '你没有订阅',
                          5 => '已经验证过或者地址失效,请勿重复验证',
                          6 => '你已经更换你的E-mail地址,请到你的邮箱确认，并且点击地址验证',
                          7 => '验证失败',
                          8 => '此E-mail已经订阅过，请更换其他邮箱地址订阅'
			             );
		return $ERRORMSG[$this->error];
	}
}
?>
