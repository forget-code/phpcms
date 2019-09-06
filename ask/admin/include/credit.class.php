<?php
class credit
{
	var $db;
	var $pages;
	var $number;
	var $table;
	var $table_member;

    function __construct()
    {
		global $db, $member;
		$this->db = &$db;
		$this->member = &$member;
		$this->table = DB_PRE.'ask_credit';
		$this->table_member = DB_PRE.'member';
    }

	function credit()
	{
		$this->__construct();
	}

	function add($info)
	{
		if(!is_array($info)) return false;
		return $this->db->insert($this->table, $info);
	}

	function edit($id, $info)
	{
		$id = intval($id);
		if(!$id || !is_array($info)) return false;
		return $this->db->update($this->table, $info, "id=$id");
	}

	function delete($id)
	{
		if(is_array($id))
		{
			array_map(array(&$this, 'delete'), $id);
		}
		else
		{
			$id = intval($id);
			if($id < 1) return false;
			$this->db->query("DELETE FROM $this->table WHERE id=$id");
		}
		return true;
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50, $flags = 0)
	{
		if(!isset($ACTOR)) $ACTOR = cache_read('actor.php');
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM $this->table $where");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$i = 1;
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$userids[] = $userid = $r['userid'];
			$r['orderid'] = $i;
			$_array[] = $array[$userid] = $r;
			$i++;
		}

		if($userids != '')
		{
			$userids = implodeids($userids);
			$data = $this->member->listinfo(" AND m.userid IN ($userids)");
			foreach($data as $r)
			{
				$userid = $r['userid'];
				$credit = $r['point'];
				$r['lastlogintime'] = date('Y-m-d H:i',$r['lastlogintime']);

				foreach($ACTOR[$r['actortype']] As $k=>$v)
				{
					if($credit >= $v['min'] && $credit <= $v['max'])
					{
						$r['grade'] = $v['grade'].' '.$v['actor'];
					}
					elseif($credit>$v['max'])
					{
						$r['grade'] = $v['grade'].' '.$v['actor'];
					}
				}
				if($flags)
				{
					$_info[$userid] = $r;
				}
				else
				{
					$info[] = array_merge($array[$userid], $r);
				}
			}
			if($flags)
			{
				foreach($_array As $r)
				{
					$userid = $r['userid'];
					$info[] = array_merge($_info[$userid], $r);
				}
			}
		}
		$info = array_filter($info);
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $info;
	}

	function cache()
	{
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		cache_write('actor.php', $array);
		$this->db->free_result($result);
		return $array;
	}
}
?>