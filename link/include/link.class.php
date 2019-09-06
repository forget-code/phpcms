<?php 
class link
{	
	var $db;
	var $table;
	var $pages;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'link';
    }

	function link()
	{
		$this->__construct();
	}

	//添加链接
	function add($arr)
	{
		if(!is_array($arr)) return false;
		$linkid = $this->db->insert($this->table, $arr);
		return $linkid;
	}

	//删除链接
	function del($linkid,$where='')
	{	if(!empty($linkid))
		{
			$linkids=is_array($linkid) ? implode(',',$linkid) : intval($linkid);
			$where = "WHERE linkid IN ($linkids)"; 
		}
		$this->db->query("DELETE FROM $this->table $where");
		return true;
	}


	//删除属于该类型的所有链接
	function deltypelink($typeid)
	{	
		$typeid = intval($typeid);
		$this->db->query("DELETE FROM $this->table WHERE typeid = $typeid ");
		return true;
	}

	//审核链接
	function check($linkid,$passed)
	{
		$linkids = is_array($linkid) ? implode(',',$linkid) : intval($linkid);
		$this->db->query("UPDATE $this->table set passed=$passed WHERE linkid IN ($linkids)");
		return true;
	}
	//添加推荐
	function elite($linkid,$elite)
	{
		$linkids = is_array($linkid) ? implode(',',$linkid) : intval($linkid);
		$this->db->query("UPDATE $this->table set elite=$elite WHERE linkid IN ($linkids)");
		return true;
	}

	//获得当前编辑链接的内容
	function get($linkid)
	{
		$linkid = intval($linkid);
		$result = $this->db->get_one("SELECT * FROM $this->table WHERE linkid=$linkid");
		return $result;
	}
	//更新排序
	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE `linkid`=$id");
		}
		return true;
	}
	//更新当前编辑链接的内容
	function update($linkinfo,$linkid)
	{
		global $LANG;
		if(empty($linkid) || !is_array($linkinfo))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$r = $this->db->update($this->table, $linkinfo," linkid=$linkid");
		return $r;
		
	}

	//更新链接的点击数
	function hits($linkid) 
	{
		return $this->db->query("UPDATE $this->table SET `hits`=hits+1 WHERE `linkid`=$linkid");
	}

	//获取链接列表
	function listinfo($where="",$order="",$page=1,$pagesize = 10)
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
		$r = $this->db->get_one("SELECT count(*) AS number FROM $this->table $where");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where ORDER BY `listorder`,`linkid` LIMIT $offset, $pagesize");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;

	}
}

?>