<?php
class card
{
	var $card_table = '';
	var $cardtype_table = '';
	var $db = '';
	var $lang ;
	function card()
	{
		global $db , $LANG;
		$this->lang		= $LANG;
		$this->db		= $db;
		$this->table_c	= DB_PRE.'pay_card';
		$this->table_t	= DB_PRE.'pay_pointcard_type';
	}

	function get_list( $condition = null, $page = 1, $pagesize )
	{

		$cards = array();
		$arg['where']	= $this->_make_condition($condition);
		$page			= max(intval($page), 1);
        $offset			= $pagesize*($page-1);
		$cards['num']	= $this->db->get_one("SELECT COUNT(*) AS number FROM `$this->table_c` WHERE 1 {$arg['where']} ");
		$cards['pages'] = pages($cards['num']['number'], $page, $pagesize);
		$sql = "SELECT *,c.amount,c.point,name FROM `$this->table_c` AS c INNER JOIN `$this->table_t` AS t ON c.ptypeid = t.ptypeid  WHERE 1 {$arg['where']}   ORDER BY `mtime` DESC LIMIT $offset,$pagesize";
		$result = $this->db->query($sql);
		while($r = $this->db->fetch_array($result))
		{
            if($r['endtime'] <= TIME && !empty($r['endtime'])) $r['endstatus'] = 1;
            $r['endtime'] = date('Y-m-d',$r['endtime']);
            $mtime = explode(" ",$r['mtime']);
            $r['mtime'] = $mtime['0'];
            $regtime = explode(" ",$r['regtime']);
            $r['regtime'] = $regtime['0'];
            $cards['info'][] = $r;
		}
		return $cards;
	}

	function add($typeid, $cardnum, $carlength, $prefix, $endtime = '')
	{
		global $_userid, $_username;
        $endtim = trim($endtime);
        if(!empty($endtime))
        {
            $endtime = strtotime($endtime);
        }
        else
        {
            $endtime = TIME+365*2*24*60*60;
        }
		$ptypeid = intval($typeid);//卡类型
		$number  = intval($cardnum); //生数量
		$length  = intval($carlength); //卡密的长度
		$prefix = intval($prefix);//卡密前缀
		$mtime = date('Y-m-d H:i:s');
		$ip = IP;
		$row = $this->db->get_one("SELECT `point`,`amount` FROM ".DB_PRE."pay_pointcard_type WHERE `ptypeid` = '{$ptypeid}' ");
		for ($i = 0 ; $i < $number ; $i++ )
		{
			$cardid = $prefix.random($length, '0123456789');
            $r = $this->checkCardId($cardid);
            if(empty($r))
            {
			    $sql = "INSERT INTO ".DB_PRE."pay_card ( `ptypeid`, `cardid`, `inputerid`, `inputer`, `mtime`, `regip`, `point`, `amount`,`endtime`) VALUES ( '{$ptypeid}','{$cardid}','{$_userid}','{$_username}','{$mtime}','{$ip}','{$row['point']}','{$row['amount']}','{$endtime}') ";
			    $this->db->query($sql);
            }
            else
            {
                continue;
            }
		}
		return true;
	}

	function drop( $ids )
	{
		$query_in = $this->db_create_in($ids);
		return $this->db->query("DELETE FROM `$this->table_c` WHERE `id` {$query_in}");
	}
    function checkCardId($cardid)
    {
        $sql = "SELECT `cardid` FROM `$this->table_c` WHERE `cardid` = '{$cardid}'";
        return $this->db->get_one($sql);
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