<?php 
class priv_group
{
	var $db;
	var $table;
	var $table_extend;
	var $groupids;

	function priv_group()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'member_group_priv';
		$this->table_extend = DB_PRE.'member_group_extend';
		$this->groupids = 0;
	}

    function add($field, $value, $priv, $groupid)
    {
		$groupid = intval($groupid);
		return $this->db->query("INSERT INTO `$this->table`(`groupid`,`field`,`value`,`priv`) VALUES('$groupid', '$field', '$value', '$priv')");
    }

	function delete($field, $value, $priv = '', $groupid = 0)
	{
		$where = '';
		if($groupid) $where .= "AND `groupid`='$groupid' ";
		if($field) $where .= "AND `field`='$field' ";
		if($value) $where .= "AND `value`='$value' ";
		if($priv) $where .= "AND `priv`='$priv' ";
		if($where)
		{
            $where = substr($where, 3);
			return $this->db->query("DELETE FROM `$this->table` WHERE $where");
		}
		return false;
	}

	function update($field, $value, $priv_group)
	{
		if(!$field || !$value) return false;
		$this->delete($field, $value);
		if(!is_array($priv_group)) return true;
		foreach($priv_group as $priv_groupid)
		{
            if(is_numeric($priv_groupid))
			{
				$priv = '';
				$groupid = $priv_groupid;
			}
			else
			{
				list($priv, $groupid) = explode(',', $priv_groupid);
			}
			$this->add($field, $value, $priv, $groupid);
		}
		return true;
	}

	function check($field, $value, $priv = '', $groupid = 0)
	{
		$r = $this->db->get_one("SELECT `groupid` FROM `$this->table` WHERE `field`='$field' AND `value`='$value' LIMIT 1");
		if(!$r) return true;
		if(!$this->groupids) $this->set_groupids();
		$groupids = $groupid ? intval($groupid) : $this->groupids;
		$where = is_numeric($groupids) ? "`groupid`=$groupids AND `field`='$field' AND `value`='$value'" : "`groupid` IN($groupids) AND `field`='$field' AND `value`='$value'";
		if($priv) $where .= " AND `priv`='$priv' ";
		return $this->db->get_one("SELECT `groupid` FROM `$this->table` WHERE $where LIMIT 1");
	}

	function get_groupid($field, $value, $priv = '')
	{
		$groupids = array();
		$array = $this->db->select("SELECT `groupid` FROM `$this->table` WHERE `field`='$field' AND `value`='$value' AND `priv`='$priv'", 'groupid');
		foreach($array as $k=>$v)
		{
			$groupids[$k] = $v['groupid'];
		}
		return $groupids;
	}

	function set_groupids()
	{
		global $_userid, $_groupid;
		$today = date('Y-m-d');
		$data = $this->db->select("SELECT `groupid` FROM `$this->table_extend` WHERE `userid`=$_userid AND `enddate`>'$today'", 'groupid');
		$this->groupids = $data ? $_groupid.','.implodeids(array_keys($data)) : $_groupid;
		return true;
	}
}
?>