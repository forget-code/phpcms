<?php
class apply
{
	var $db;
	var $table;
	var $userid = 0;
	var $userid_sql = '';
	var $pages;
	var $number;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'yp_apply';
    }

	function apply()
	{
		$this->__construct();
	}

	function set_userid($userid)
	{
		$this->userid = intval($userid);
		$this->userid_sql = " AND $this->table.`userid`=$this->userid ";
	}
	function get($id,$isvisitor = 0)
	{
		$id = intval($id);
		$sql = "SELECT * FROM `$this->table` WHERE `applyid`=$id";
		if(!$isvisitor) $sql .= " $this->userid_sql";
		$data = $this->db->get_one($sql);
		return $data;
	}
	
	function get_userapply($userid, $field)
	{
		$userid = intval($userid);
		$data = $this->db->get_one("SELECT $field FROM `$this->table` WHERE `userid`='$userid'");
		return $data;
	}

	function add($info)
	{
		$this->db->insert($this->table, $info);
		$id = $this->db->insert_id();
		return $id;
	}

	function edit($id, $info)
	{
		$this->db->update($this->table, $info,"applyid='$id' $this->userid_sql");
		return true;
	}

	function listinfo($where = '', $order = '`listorder` DESC,`applyid` DESC', $page = 1, $pagesize = 30)
	{
		if($where) $where = " WHERE $where $this->userid_sql";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
        $number = cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}
	
	function elite($id, $status = 0)
	{
		$status = intval($status);
		if(is_array($id))
		{
			$id = implodeids($id);
			$this->db->query("UPDATE `$this->table` SET `elite`='$status' WHERE `applyid` IN ($id) $this->userid_sql");
		}
		else
		{
			$this->db->query("UPDATE `$this->table` SET `elite`='$status' WHERE `applyid`='$id' $this->userid_sql");
		}
		return true;
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
			$this->db->query("DELETE FROM `$this->table` WHERE `applyid`='$id'");
		}
		return true;
	}

	function status($id, $status)
	{
		if(!$id) return false;
		$status = intval($status);
		$ids = implodeids($id);
		$this->db->query("UPDATE `$this->table` SET `status`=$status WHERE `applyid` IN($ids) $this->userid_sql");
		return true;
	}
	
	function refresh($id)
	{
		if(!$id)return false;
		$time = time();
		$this->db->query("UPDATE `$this->table` SET `edittime` = '{$time}' WHERE `applyid` = '{$id}' $this->userid_sql");
		return true;
	}
	
	function post_apply($jobid,$apply)
	{
		if(!$jobid)return false;
		if(isset($apply['applyid']))
		{
			$time = time();
			$sql = "INSERT INTO `".DB_PRE."yp_stock` (`jobid`,`applyid`,`label`,`addtime`) VALUES ('{$jobid}','{$apply['applyid']}','1','{$time}')";
			$this->db->query($sql);
			return true;
		}else return false;
	}
	
	function is_post_apply($jobid,$applyid,$label = 1)
	{
		$jobid = intval($jobid);
		$applyid = intval($applyid);
		$sql = "SELECT * FROM `".DB_PRE."yp_stock` WHERE jobid = '{$jobid}' AND applyid = '{$applyid}' AND label = '{$label}'";
		return $this->db->get_one($sql);
	}
	
	function favor_job($jobid,$apply)
	{
		if(!$jobid)return false;
		if(isset($apply['applyid']))
		{
			$time = time();
			$sql = "INSERT INTO `".DB_PRE."yp_stock` (`jobid`,`applyid`,`label`,`addtime`) VALUES ('{$jobid}','{$apply['applyid']}','0','{$time}')";
			$this->db->query($sql);
			return true;
		}else return false;
	}
	
	function del_favor_job($stockid,$applyid)
	{
		if(!$stockid)return false;
		$sql = "DELETE FROM `".DB_PRE."yp_stock` WHERE stockid = '{$stockid}' AND applyid = '{$applyid}'";
		$this->db->query($sql);
		return true;
	}
	
	function get_stock_list($lable,$applyid,$page = 1,$limit = 15)
	{
		$label = intval($label);
		$start = ($page - 1)*$limit;
		if($start < 0)$start = 0;
		$sql = "SELECT COUNT(*) AS number FROM `".DB_PRE."yp_stock` WHERE applyid = '{$applyid}' AND label = '{$lable}'";
		$t = $this->db->get_one($sql);
		$sql = "SELECT s.*,j.id,j.title,c.userid,c.companyname FROM `".DB_PRE."yp_stock` `s`,`".DB_PRE."yp_job` `j`,`".DB_PRE."member_company` `c` WHERE s.jobid = j.id AND c.userid = j.userid AND s.applyid = '{$applyid}' AND s.label = '{$lable}' ORDER BY s.addtime DESC LIMIT {$start},{$limit}";
		$r = $this->db->select($sql);
		return array('number'=>$t['number'],'result'=>$r);
	}
	
	function show_apply($stockid,$status = 1)
	{
		if(!$stockid)return false;
		$sql = "UPDATE `".DB_PRE."yp_stock` SET status = '{$status}' WHERE stockid = '{$stockid}'";
		$this->db->query($sql);
		return true;
	}
	
	function get_job_stock_list($userid,$page = 1,$limit = 15)
	{
		$start = ($page - 1)*$limit;
		if($start < 0)$start = 0;
		$where = "j.userid = '{$userid}' AND a.applyid = s.applyid AND s.jobid = j.id AND s.label = '1' ORDER BY s.addtime DESC LIMIT {$start},{$limit}";
		$sql = "SELECT count(*) AS number FROM `".DB_PRE."yp_stock` `s`,`".DB_PRE."yp_job` `j`,`".DB_PRE."yp_apply` `a` WHERE {$where}";
		$t = $this->db->get_one($sql);
		$sql = "SELECT s.*,j.id,j.title,a.truename FROM `".DB_PRE."yp_stock` `s`,`".DB_PRE."yp_job` `j`,`".DB_PRE."yp_apply` `a` WHERE {$where}";
		$r = $this->db->select($sql);
		return array('number'=>$t['number'],'result'=>$r);
	}
	
	function get_stock_by_id($stockid)
	{
		if(!$stockid)return false;
		$sql = "SELECT * FROM `".DB_PRE."yp_stock` WHERE stockid = '{$stockid}'";
		$r = $this->db->get_one($sql);
		return $r;
	}
	
	function get_stock_by_useridandapplyid($userid,$applyid)
	{
		$userid = intval($userid);
		$applyid = intval($applyid);
		$sql = "SELECT * FROM `".DB_PRE."yp_stock` `s`,`".DB_PRE."yp_job` `j` WHERE j.userid = '{$userid}' AND j.id = s.jobid AND s.applyid = '{$applyid}' LIMIT 1";
		$r = $this->db->get_one($sql);
		return $r;
	}
	
	function get_userid_by_applyid($id)
	{
		$id = intval($id);
		$data = $this->db->get_one("SELECT userid FROM `$this->table` WHERE `applyid`='{$id}'");
		return $data;
	}
	
	function get_userid_by_jobid($id)
	{
		$id = intval($id);
		$data = $this->db->get_one("SELECT j.*,c.companyname FROM `".DB_PRE."yp_job` `j`,`".DB_PRE."member_company` `c` WHERE c.userid = j.userid AND j.id ='{$id}'");
		return $data;
	}
	
	function search_apply_result($q,$inputtime,$degree,$station,$workplace,$experience,$page = 1,$limit = 15)
	{
		$where = '';
		$inputtime = intval($inputtime);
		if(!$inputtime ||  $inputtime== "不限")
		{
			$time = 0;
		}
		else
		{
			$time = time() - 3600*24*intval($inputtime);
		}
		$where .= "j.edittime >= '{$time}' ";
		$degree = urldecode($degree);
		if($degree && $degree != '不限')
		{
			$degree = addslashes(htmlspecialchars($degree));
			$where .= "AND j.edulevel = '{$degree}' ";
		}
		$station = intval($station);
		if($station)
		{			
			$where .= "AND j.station = '{$station}' ";
		}
		$workplace = urldecode($workplace);
		if($workplace && $workplace != "不限")
		{
			$workplace = addslashes(htmlspecialchars($workplace));
			$where .= "AND j.area = '{$workplace}' ";
		}
		$experience = intval($experience);
		if($experience)
		{
			$where .= "AND j.experience >= '{$experience}' ";
		}
		$where .= "AND j.status = '3'";
		$sql = "SELECT count(*) AS number FROM `".$this->table."` `j` WHERE {$where}";
		$n = $this->db->get_one($sql);
		$start = intval($page-1)*$limit;
		$sql = "SELECT * FROM `".$this->table."` `j` WHERE {$where} LIMIT {$start},{$limit}";
		$r = $this->db->select($sql);
		return array("number" => $n['number'],"result" => $r);
	}
}
?>