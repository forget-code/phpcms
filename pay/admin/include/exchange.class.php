<?php
class exchange
{
	var $logs_table = '';
	var $db = '';
	var $lang ;
	var $pay = '';

	function exchange()
	{
		global $db , $LANG;
		$this->pay	= load('pay_api.class.php', 'pay', 'api');
		$this->lang = $LANG;
		$this->db	= $db;
        $this->table_cache = DB_PRE.'member_cache';
		$this->table_exchange = DB_PRE.'pay_exchange';
	}
    //order: sort=id&order=
	function get_list( $condition = null, $page = 1, $pagesize)
	{
        global $MODULE;
		$page		= max(intval($page), 1);
        $offset		= $pagesize*($page-1);
        $sort = (!empty($_GET['sort']) && preg_match('/^[\w]+$/', $_GET['sort']) > 0) ? trim($_GET['sort']) : 'id';
        $order = (!empty($_GET['order']) && strtolower($_GET['order']) == 'asc') ? 'ASC' : 'DESC';
		$exchange	= array();
		$arg['where']		= $this->_make_condition($condition);
		$exchange['num']	= $this->db->get_one("SELECT COUNT(*) AS number FROM `$this->table_exchange` WHERE 1 {$arg['where']} ");
		$exchange['pages']	= pages($exchange['num']['number'], $page, $pagesize);

		$sql = "SELECT * FROM `$this->table_exchange` WHERE 1 {$arg['where']} ORDER BY $sort $order LIMIT $offset,$pagesize";
		$result = $this->db->query($sql);
		$point = $amount = '0';
        $ip_area = load('ip_area.class.php');
		while($r = $this->db->fetch_array($result))
		{
			$money[$r['type']][] = $r['number'];
			if($r['type'] == 'point'){$point = $point + $r['number'];}
			if($r['type'] == 'amount'){$amount = $amount + $r['number'];}
			$r['type'] = $this->lang[$r['type']];
			$r['module'] = $MODULE[$r['module']]['name'];
            list($r['ip_area'], ) = explode(" ",$ip_area->get($r['ip']));
			$exchange['info'][] = $r;
		}
		$exchange['point'] = $point;
		$exchange['amount'] = $amount;
		return $exchange;
	}

	function drop($ids)
	{
		$query_in = $this->db_create_in($ids);
		$sql = "DELETE FROM `$this->table_exchange` WHERE `id` {$query_in}";
		return $this->db->query($sql);
	}

	function update_exchange($module, $type, $number, $note, $userid)
	{
        if(!$this->pay->update_exchange($module, $type, $number, $note, $userid))
        {
            showmessage($this->pay->error());
        }
        else
        {
            return true;
        }
	}
    function username_exists($username, $userid='')
	{
		if(!isset($username) && empty($username))
		{
			return false;
		}
		$result = $this->db->get_one("SELECT userid FROM `$this->table_cache` WHERE username='$username' AND userid!='$userid'");
		if($result)
		{
			return false;
		}
		return $username;
	}
	function _make_condition($conditions)
	{
		$where = '';
		if(is_array($conditions))
		{
			$where .= implode(' AND ', $conditions);
		}
		if ($where){
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