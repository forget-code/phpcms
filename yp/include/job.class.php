<?php

class job
{
	var $db;
	var $table;
	
	function job()
	{
		$this->__construct();
	}
	
	function __construct()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE."yp_job";
	}
	
	function search_job_result($q,$inputtime,$degree,$station,$workplace,$experience,$page = 1,$limit = 15)
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
		$where .= "j.updatetime >= '{$time}' ";
		if($degree)
		{
			$degree = addslashes(htmlspecialchars($degree));
			$where .= "AND j.degree = '{$degree}' ";
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
			$where .= "AND j.workplace = '{$workplace}' ";
		}
		$experience = intval($experience);
		if($experience)
		{
			$where .= "AND j.experience = '{$experience}' ";
		}
		$q = urldecode($q);
		if($q && $q != "公司或者职位关键字")
		{
			$q = addslashes(htmlspecialchars($q));
			$where .= "AND j.title LIKE '%{$q}%' ";
		}
		$where .= "AND j.status = '99'";
		$sql = "SELECT count(*) AS number FROM `".$this->table."` `j` WHERE {$where}";
		$n = $this->db->get_one($sql);
		$start = intval($page-1)*$limit;
		$sql = "SELECT j.*,c.companyname FROM `".$this->table."` `j` LEFT JOIN `".DB_PRE."member_company` `c` ON c.userid = j.userid WHERE {$where} LIMIT {$start},{$limit}";
		$r = $this->db->select($sql);
		return array("number" => $n['number'],"result" => $r);
	}	
}

?>