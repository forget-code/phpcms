<?
class comment
{
	var $_table = '';
	var $_db ;
	function comment()
	{
		global $db;
		$this->_table = DB_PRE.'comment';
		$this->count_table = DB_PRE.'content_count';
		$this->_db= $db;
	}

	function get_list( $condition = null, $page = 1, $pagesize )
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $sort = (!empty($_GET['sort']) && preg_match('/^[\w]+$/', $_GET['sort']) > 0) ? trim($_GET['sort']) : 'addtime';
        $order = (!empty($_GET['order']) && strtolower($_GET['order']) == 'asc') ? 'ASC' : 'DESC';
		$comments = array();
		$arg['where'] = $this->_make_condition($condition);
		$comments['num'] = $this->_db->get_one("SELECT COUNT(*) AS number FROM `$this->_table` WHERE 1 {$arg['where']} ");
		$comments['pages'] = pages($comments['num']['number'], $page, $pagesize);
		$sql = "SELECT * FROM `$this->_table` where 1 {$arg['where']} ORDER BY `$sort` $order limit $offset,$pagesize";
        $result = $this->_db->query($sql);
		require_once PHPCMS_ROOT.'include/ip_area.class.php';
		$ip_area = new ip_area();
		while($r = $this->_db->fetch_array($result)){
			//$r['content'] = nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($r['content'], ENT_QUOTES)));
			$r['content']	= preg_replace_callback("/\[smile_[0-9]{1,3}\]/", 'smilecallback', $r['content']);
			$r['content']	= str_replace( '[quote]', '<div class="bdr_1">', $r['content']);
			$r['content']	= str_replace( '[/quote]', '</div>', $r['content']);
			$r['content']	= str_replace( '[blue]', '<span style="color:blue">', $r['content']);
			$r['content']	= str_replace( '[/blue]', '</span><br/>', $r['content']);
			$r['addtime']	= date("Y-m-d",$r['addtime']);
			$r['area']		= $ip_area->get($r['ip']);
			$key = keyid_get($r['keyid']);
			$r['url'] = $key['url'];
			$comments['info'][] = $r;
		}
		return $comments;
	}

	function drop($ids)
	{
        if($this->dropCount($ids))
        {
            $query_in = $this->db_create_in($ids);
		    return $this->_db->query("DELETE FROM `$this->_table` WHERE `commentid` {$query_in}");
        }
	}
    //Modify count
    function dropCount($contentids)
    {
        if(is_array($contentids))
		{
			foreach ($contentids as $id)
			{
				$row = $this->_db->get_one("SELECT `keyid` FROM `$this->_table` WHERE `commentid` = '{$id}' ");
				list($module, $tablename, $titlefield, $contentid) = explode('-', $row['keyid']);
                $sql = "UPDATE `$this->count_table` SET `comments` = comments - '1' WHERE `contentid` = '$contentid'";
				$this->_db->query($sql);
			}
            return true;
		}
		else
		{
			$row = $this->_db->get_one("SELECT `keyid` FROM `$this->table` WHERE `commentid` = '{$contentids}' ");
			list($module, $tablename, $titlefield, $contentid) = explode('-', $row['keyid']);
			$this->_db->query("UPDATE `$this->count_table` SET `comments` = comments - '1' WHERE `contentid` = '$contentid'");
		}
    }

	function pass($ids, $status)
	{
		$status = intval($status);
		$query_in = $this->db_create_in($ids);
		if( $this->_db->query("UPDATE `$this->_table` SET `status` = '$status' WHERE `commentid` {$query_in}") )
		{
			return $this->updatecounter($ids);
		}
	}

	function updatecounter($contentids)
	{
		if(is_array($contentids))
		{
			foreach ($contentids as $id)
			{
				$row = $this->_db->get_one("SELECT `keyid` FROM `$this->_table` WHERE `commentid` = '{$id}' ");
				list($module, $tablename, $titlefield, $contentid) = explode('-', $row['keyid']);
				$this->_db->query("UPDATE `$this->count_table` SET `comments_checked` = comments_checked + '1' WHERE `contentid` = '$contentid'");
			}
		}
		else
		{
			$row = $this->_db->get_one("SELECT `keyid` FROM `$this->table` WHERE `commentid` = '{$contentids}' ");
			list($module, $tablename, $titlefield, $contentid) = explode('-', $row['keyid']);
			$this->_db->query("UPDATE `$this->count_table` SET `comments_checked` = comments_checked + '1' WHERE `contentid` = '$contentid'");
		}
		return true;
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