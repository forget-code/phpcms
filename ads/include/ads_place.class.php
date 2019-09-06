<?php
defined('IN_PHPCMS') or exit('Access Denied');
class ads_place
{
	var $adsid = 0;
	var $db = '';
	var $table = '';
	var $referer = '';

	function ads_place($ads_placeid = 0)
	{
		global $db;
		$this->db = $db;
		$this->adsid = $ads_placeid;
		$this->table = DB_PRE.'ads_place';
		$this->referer = HTTP_REFERER;
		$this->stat_table = DB_PRE.'ads_'.date('ym',TIME);
	}

	function get($ads_placeid, $fields = '*')
	{
		$ads_placeid = intval($ads_placeid);
		return $this->db->get_one("SELECT $fields FROM ".$this->table." WHERE placeid=$ads_placeid");
	}

	function add($place)
	{
		if(!$this->check($place)) return false;
		$this->db->insert($this->table, $place);
		return $this->db->insert_id();
	}

	function edit($place, $where)
	{
		if(!$this->check($place)) return false;
		return $this->db->update($this->table, $place, $where);
	}

	function get_info($ads_placeid)
	{
		$ads_placeid = intval($ads_placeid);
		return $this->db->get_one("SELECT * FROM ".$this->table." WHERE placeid = $ads_placeid");
	}

	function page()
	{
		global $page, $M;
		$page = $page ? intval($page) : 1;
		$pagesize = $M['pagesize'] ? intval($M['pagesize']) : 20;
		$pagesize = intval($pagesize);
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM $this->table");
		$number=$r['num'];
		return pages($number, $page, $pagesize);
	}

	function manage($where, $todate = 0)
	{
		global $page, $M;
		$page = $page ? intval($page) : 1;
		$pagesize = $M['pagesize'] ? intval($M['pagesize']) : 20;
		$offset = ($page-1)*$pagesize;
		$todate = intval($todate);
		if($todate)
		{
			$re = $this->db->select("SELECT * FROM ".$this->table." $where ORDER BY placeid LIMIT $offset, $pagesize");
			$now_time = time();
			foreach($re as $key => $value)
			{
				$todate = $this->db->get_one("SELECT todate FROM ".DB_PRE."ads WHERE placeid=$value[placeid] AND fromdate<=$now_time AND todate>=$now_time AND passed=1 AND status=1 LIMIT 1");
				$re[$key]['todate'] = date('Y-m-d', $todate['todate']);
			}
		}
		else
		{
 			$re = $this->db->select("SELECT * FROM ".$this->table." $where ORDER BY placeid LIMIT $offset, $pagesize");
		}
		return $re;
	}
    function get_list($condition = null, $page = 1)
	{
		global $M;
        $ads =$re= array();
		$page = $page ? intval($page) : 1;
		$pagesize = $M['pagesize'] ? intval($M['pagesize']) : 20;
		$offset = ($page-1)*$pagesize;
        $arg['where']		= $this->_make_condition($condition);
        $r	=   $this->db->get_one("SELECT COUNT(*) AS `num` FROM `$this->table` WHERE 1 {$arg['where']} ");
		$re['pages']	= pages($r['num'], $page, $pagesize);
		$re['info']     = $this->db->select("SELECT * FROM `$this->table` WHERE 1 {$arg['where']} ORDER BY `placeid` LIMIT $offset, $pagesize");
		return $re;
	}

	function check($place)
	{
		if(!is_array($place)) return FALSE;
		if(strlen($place['placename']) <2 || strlen($place['placename']) >30)
		{
			$this->errormsg = 'ads_invalid_name';
			return false;
		}
		$badwords = array("\\", '&', "'", '"', '/', '*', '<', '>', "\r", "\t", "\n", '#');

		foreach($badwords as $value)
		{
			if(strpos($place['placename'], $value) !== false)
			{
				$this->errormsg = 'illegal_name';
				return false;
			}
		}
		foreach($badwords as $value)
		{
			if(strpos($place['introduce'], $value) !== false) {
			$this->errormsg = 'illegal_discription';
			return false;
			}
		}

		if (!is_numeric($place['price']))
		{
			$this->errormsg = 'please_enter_the_advertisement_price';
			return false;
		}

		if (!is_numeric($place['height']) && !is_numeric($place['weight']))
		{
			$this->errormsg = 'the_height_and_width_of_the_advertisement_must_be_a_integer';
			return false;
		}
		return true;
	}

	function delete($arrid)
	{
		global $priv_role, $roleid;
		foreach($arrid as $id)
		{
			if(!$priv_role->check('p_adsid', $id, 'manage', $roleid))
			continue;
			$this->db->query("DELETE FROM $this->table WHERE placeid=$id");
		}
		return true;
	}

	function lock($arrid, $val)
	{
		global $priv_role, $roleid;
		$val = intval($val);
		foreach($arrid as $id)
		{
			if(!$priv_role->check('p_adsid', $id, 'manage', $roleid))
			continue;
			$this->db->query("UPDATE ".$this->table." SET `passed`=$val WHERE placeid=$id");
		}
		return true;
	}

	function createhtml($placeid, $isjs, $option)
	{
		global $M;
		$placeid = intval($placeid);
		$isjs = intval($isjs);
		$option = intval($option);
		if(!$placeid) return false;
		if($option)
		{
			$contents = array();
			$adses = $this->db->select("SELECT * FROM ".DB_PRE."ads a, $this->table p WHERE a.placeid=p.placeid AND p.placeid=$placeid AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND a.passed=1 AND a.status=1");
			foreach($adses as $ads)
			{
				$contents[] = ads_content($ads, $isjs);
			}
			$template = $ads['template'] ? $ads['template'] : 'ads';
		}
		else
		{
			$ads = $this->db->get_one("SELECT * FROM ".DB_PRE."ads a, $this->table p WHERE a.placeid=p.placeid AND p.placeid=$placeid AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND a.passed=1 AND a.status=1 ORDER BY rand() LIMIT 1");
			$contents[] = ads_content($ads, $isjs);
			$template = $ads['template'] ? $ads['template'] : 'ads';
		}
		$dir = PHPCMS_ROOT.'/data/'.$M['htmldir'];
		is_dir($dir) or dir_create($dir);

		ob_start();
		include template('ads', $template);
		$data = ob_get_contents();
		ob_clean();
		$filename = $isjs ? $dir.'/'.$placeid.'.js' : $dir.'/'.$placeid.'.html';
		file_put_contents($filename, $data);
		@chmod($filename, 0777);
		ob_end_flush();
		return true;
	}

	function view($placeid, $option)
	{
		$placeid = intval($placeid);
		$option = intval($option);
		$contents = array();
		if($option)
		{
			$adses = $this->db->select("SELECT * FROM ".DB_PRE."ads a, $this->table p WHERE a.placeid=p.placeid AND p.placeid=$placeid AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND a.passed=1 AND a.status=1");
			foreach($adses as $ads)
			{
				$contents[] = ads_content($ads, 1);
			}
			$template = $ads['template'] ? $ads['template'] : 'ads';
		}
		else
		{
			$ads = $this->db->get_one("SELECT * FROM ".DB_PRE."ads a, $this->table p WHERE a.placeid=p.placeid AND p.placeid=$placeid AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND a.passed=1 AND a.status=1 ORDER BY rand() LIMIT 1");
			$contents[] = ads_content($ads);
			$template = $ads['template'] ? $ads['template'] : 'ads';
		}
		include template('ads', $template);
	}

	function show($placeid)
	{
		global $_username;
		$placeid = intval($placeid);
		if(!$placeid) return FALSE;
		$ip = IP;
		$time = time();

		$adses = $this->db->select("SELECT * FROM ".DB_PRE."ads a, $this->table p WHERE a.placeid=p.placeid AND p.placeid=$placeid AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND a.passed=1 AND a.status=1 AND p.passed=1");
		if($adses[0]['option'])
		{
			foreach($adses as $ads)
			{
				$contents[] = ads_content($ads, 1);
				//对数据进行过滤
				$referer = safe_replace($this->referer);
				$this->db->query("INSERT INTO $this->stat_table (`adsid`, `username`, `ip`, `referer`, `clicktime`, `type`) VALUES ('$ads[adsid]', '$_username', '$ip', '$referer', '$time', '0')");
				$template = $ads['template'] ? $ads['template'] : 'ads';
			}
		}
		else
		{
			$ads = $this->db->get_one("SELECT * FROM ".DB_PRE."ads a, $this->table p WHERE a.placeid=p.placeid AND p.placeid=$placeid AND a.fromdate<=UNIX_TIMESTAMP() AND a.todate>=UNIX_TIMESTAMP() AND a.passed=1 AND a.status=1 ORDER BY rand() LIMIT 1");
			$contents[] = ads_content($ads, 1);
			//对数据进行过滤
			$referer = safe_replace($this->referer);
			$this->db->query("INSERT INTO $this->stat_table (`adsid`, `username`, `ip`, `referer`, `clicktime`, `type`) VALUES ('$ads[adsid]', '$_username', '$ip', '$referer', '$time', '0')");
			$template = $ads['template'] ? $ads['template'] : 'ads';
		}
		include template('ads', $template);
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

	function msg()
	{
		global $LANG;
		return $LANG[$this->errormsg];
	}
}
?>