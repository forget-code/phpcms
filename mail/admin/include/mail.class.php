<?php
class mail
{
	var $db = "";
	var $mail_table = "";
	var $mail_type_table = "";
	var $lang = "";

	function mail()
	{
		global $db , $LANG;
		$this->lang = $LANG;
		$this->db = $db;
		$this->table_mail = DB_PRE.'mail_email';
		$this->table_mail_type = DB_PRE.'mail_email_type';
	}

	function get_list( $condition = null, $page = 1, $pagesize , $typeid)
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
		$arg['where'] = $this->_make_condition($condition);
		$mails = array();
		if($typeid)
        {
		    $sqlcoun = "SELECT COUNT(*) AS number FROM `$this->table_mail` INNER JOIN `$this->table_mail_type` ON $this->table_mail.email = $this->table_mail_type.email WHERE `typeid` = '$typeid' AND `status` ='1'";
			$sql ="SELECT * FROM `$this->table_mail` INNER JOIN `$this->table_mail_type` ON $this->table_mail.email = $this->table_mail_type.email WHERE `typeid` = '$typeid' AND `status` ='1' limit $offset,$pagesize" ;
		}
		else
		{
			$sqlcoun = "SELECT COUNT(*) AS number FROM `$this->table_mail` WHERE 1 {$arg['where']}";
			$sql = "SELECT `email` ,`userid` ,`username` ,`ip` ,`addtime`, `status` FROM `$this->table_mail` WHERE 1  {$arg['where']} ORDER BY `addtime` limit $offset,$pagesize";
		}
		$mails['num'] = $this->db->get_one($sqlcoun);
		$mails['pages'] = pages($mails['num']['number'], $page, $pagesize);
        require_once PHPCMS_ROOT.'include/ip_area.class.php';
		$ip_area = new ip_area();
		$result = $this->db->query($sql);
		while($r = $this->db->fetch_array($result))
		{
			$r['state_description'] = $this->lang[$r['status'].'_activation'];
			$r['area'] = $ip_area->get($r['ip']);
			$r['addtime'] = date('Y-m-d' , $r['addtime']);
			$mails['info'][] = $r;
		}
		return $mails;
	}

	function drop( $email )
	{
		if (!is_email($email))
		{
			return false;
		}
		if($this->db->query("DELETE FROM `$this->table_mail` WHERE `email` = '{$email}'"))
		{
			$sql = "DELETE FROM `$this->table_mail_type` WHERE `email` = '{$email}' ";
			return $this->db->query($sql);

		}

	}

	function clear()
	{
		$time = TIME;
		$sql = "DELETE FROM `$this->table_mail` WHERE `addtime` < '$time' -30*24*60*60 AND `status` = '0' ";
		return $this->db->query($sql);
	}

	function verify($email)
	{
		if (is_email($email))
		{
			$sql = "UPDATE `$this->table_mail` SET `authcode` = '' , `status` = '1' WHERE `email` = '$email'";
			return $this->db->query( $sql );
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

	function _make_condition($conditions)
	{
		$where = '';
        if(is_array($conditions))
		{
			$where .= implode(' AND ', $conditions);
		}
        if ($where)
        {
		    return ' AND ' . $where;
        }
	 }

}
?>