<?php
class useramount
{
	var $_amount_table = '';
	var $_db = '';
	var $pay ='';
	var $typeid = 0;

	function __construct($typeid = 0)
	{
		$this->useramount($typeid);
	}

	function useramount($typeid = 0)
	{
		global $db;
		$this->_db		= $db;
		$this->typeid	= $typeid;
		$this->pay		= load('pay_api.class.php', 'pay', 'api');
		$this->table_amount = DB_PRE.'pay_user_account';
	}

	/**
	 *
	 *	@params
	 *	@return
	 */

	function get_list($condition = null, $page = 1, $pagesize)
	{
		$list = array();
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
		$lists = $money = array();
		$arg['where'] = $this->_make_condition($condition);
		$lists['num'] = $this->_db->get_one("SELECT COUNT(*) AS number FROM `$this->table_amount` WHERE `type` = '{$this->typeid}' {$arg['where']} ");
		$lists['pages'] = pages($lists['num']['number'], $page, $pagesize);
		$sql = "SELECT * FROM `$this->table_amount` where `type` = '{$this->typeid}' {$arg['where']} ORDER BY `id` DESC limit $offset,$pagesize";
		$result = $this->_db->query($sql);
		while($row = $this->_db->fetch_array($result))
		{
			$row['addtime'] = date('Y-m-d' , $row['addtime']);
			if($row['paytime'] == '' || $row['paytime'] == '0')
            {
                $row['paytime'] = '';
            }
            else
            {
                $row['paytime'] = date('Y-m-d' , $row['paytime']);
            }
			$lists['info'][] = $row;
		}
		return $lists;
	}

	function view($id, $userid = null)
	{
		$list = array();
		if (empty($userid))
		{
			$sql = "SELECT * FROM `$this->table_amount` WHERE `id` = '$id' AND `type` = '{$this->typeid}' ";
		}
		else
		{
			$sql = "SELECT * FROM `$this->table_amount` WHERE `id` = '$id' AND `userid` = '{$userid}' AND `type` = '{$this->typeid}' ";
		}
		 $list = $this->_db->get_one($sql);
		 return $list;
	 }

	function drop($id ,$condition = null)
	{
		$query_in = $this->db_create_in($id);
		$arg['where'] = $this->_make_condition($condition);
		$sql = "DELETE FROM `$this->table_amount` WHERE `id` {$query_in} {$arg['where']} ";
		return $this->_db->query($sql);
	}

	function check($id, $data = array())
	{
		global $_userid,$_username;
		$data['inputerid']	= $_userid;
		$data['inputer']	= $_username;
		$data['paytime']	= TIME;
		$id = intval($id);
		if ($data['ispay'])
		{
			$module = 'pay'; $type= 'amount'; $note = '用户充值';
			$info		= $this->get_one($id);
			$number		= $info['quantity'];
			$userid		= $info['userid'];
			$username	= $info['username'];
			if($this->pay->update_exchange($module, $type, $number, $note, $userid))
			{
				return $this->_db->update($this->table_amount, $data, "id='$id'");
			}
		}
		else
		{
			return $this->_db->update($this->table_amount, $data, "id='$id'");
		}
	}

	function get_one( $id, $userid=null)
	{
		$list = array();
		if (empty($userid))
		{
			$sql = "SELECT * FROM `$this->table_amount` WHERE `id` = '$id'";
		}
		else
		{
			$sql = "SELECT * FROM `$this->table_amount` WHERE `id` = '$id' AND `userid` = '{$userid}' ";
		}
		 $list = $this->_db->get_one($sql);
		 return $list;
	}

	function update($data= array(),$where)
	{
		 return $this->_db->update($this->table_amount , $data, $where);
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