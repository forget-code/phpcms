<?php
class error
{
	var $db;
	var $table_error;
    var $pay ;
	function error()
	{
		global $db;
		$this->db = $db;
		$this->table_error = DB_PRE.'error_report';
	}
	function get_list( $condition = null, $page = 1, $pagesize )
	{

		$errors = array();
		$arg['where']	= $this->_make_condition($condition);
		$page			= max(intval($page), 1);
        $offset			= $pagesize*($page-1);
		$errors['num']	= $this->db->get_one("SELECT COUNT(*) AS number FROM `$this->table_error` WHERE 1 {$arg['where']} ");
		$errors['pages'] = pages($errors['num']['number'], $page, $pagesize);
		$sql = "SELECT * FROM `$this->table_error`  WHERE 1 {$arg['where']}   ORDER BY `error_id` DESC LIMIT $offset,$pagesize";
		$result = $this->db->query($sql);
		while($r = $this->db->fetch_array($result))
		{
			$errors['info'][] = $r;
		}
		return $errors;
	}

	function drop( $ids, $where='' )
	{
		if(!empty($ids))
		{
			$query_in = $this->db_create_in($ids);
			$where = 'where `error_id` '.$query_in;
		}
		return $this->db->query("DELETE FROM `$this->table_error` $where");
	}

	function check($ids)
	{
        global $M, $_userid, $_username;
        if($M['ispoint'])
        {
            $this->pay	= load('pay_api.class.php', 'pay', 'api');
            $module = 'error_report';
            $type = 'point';
            $number = $M['ispoint'];
            $note = "提交错误报告";
            $userids = $this->getErrorUser($ids);
            $this->pay->update_exchange($module, $type, $number, $note, $userids);
        }
        $query_in = $this->db_create_in($ids);
		return $this->db->query("UPDATE `$this->table_error` SET `status` = '1' WHERE `error_id` {$query_in}");
	}

	function add($setting = array())
	{
        global $_userid, $_username;
        $setting['status'] = '0';
        $setting['addtime'] = TIME;
        if(!$_userid) { $setting['username'] = '游客'; }else{ $setting['username'] = $_username; $setting['userid'] = $_userid;}
        return $this->db->insert($this->table_error, $setting);
	}
    function getErrorUser($ids)
    {
        $query_in = $this->db_create_in($ids);
        $sql = "SELECT `userid` FROM `$this->table_error` WHERE `error_id` ".$query_in;
        $userids = array();
        $result = $this->db->query($sql);
		while($r = $this->db->fetch_array($result))
		{
            if(!empty($r['userid']))
            {
                $userids[] = $r['userid'];
            }
		}
        return $userids;
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
}
?>