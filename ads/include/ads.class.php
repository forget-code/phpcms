<?php
defined('IN_PHPCMS') or exit('Access Denied');

class ads
{
	var $adsid = 0;
	var $db = '';
	var $table = '';

	function ads($adsid = 0)
	{
		global $db;
		$this->adsid = $adsid;
		$this->db = $db;
		$this->table = DB_PRE.'ads';
		$this->stat_table = DB_PRE.'ads_'.date('ym',TIME);
	}

	function check_form($ads)
	{
		global $action;
		if(!is_array($ads)) return FALSE;
		$_values = $this->db->select("SELECT placeid,placename FROM ".DB_PRE."ads_place ORDER BY placeid", 'placeid');

		$_adsplaces[] = $r;
		if(!$this->check_ads_name($ads['adsname'])) return FALSE;

		if($_values[$ads['placeid']]['placename']=='')
		{
			$this->errormsg = 'incorrect_advertisement_published';
			return FALSE;
		}

		if(!$ads['adsname'])
		{
			$this->errormsg = 'adsname_is_not_empty';
			return FALSE;
		}
		if($action != 'edit' && defined('IN_ADMIN'))
		{
			if(!$ads['fromdate'])
			{
				$this->errormsg = 'input_the_advertising_begin_time';
				return FALSE;
			}

			if(!$ads['todate'])
			{
				$this->errormsg = 'input_the_advertising_end_time';
				return FALSE;
			}
		}
		if($ads['type']=="image")
		{
			if(!strlen($ads['imageurl']))
			{
				$this->errormsg = 'input_advertising_images_url';
				return FALSE;
			}
		}
		if($ads['type']=="flash")
		{
			if(!strlen($ads['flashurl']))
			{
				$this->errormsg = 'please_input_the_flash_url';
				return FALSE;
			}
		}

		if($ads['type']=="text")
		{
			if(!$ads['text'])
			{
				$this->errormsg = 'please_input_the_advertising_content';
				return FALSE;
			}
		}

		if($ads['type']=="code")
		{
			if(!$ads['code'])
			{
				$this->errormsg = 'please_input_the_advertising_code';
				return FALSE;
			}
			$ads['linkurl'] = $ads['text_link'];
		}
		unset($ads['text_link']);
		if($ads['linkurl'] == '' || $ads['linkurl'] == 'http://')
		$ads['linkurl'] = '';
		return $ads;
	}

	function add($ads)
	{
		if(!$this->check_form($ads)) return FALSE;
		$ads = $this->check_form($ads);
		$ads['addtime'] = time();
		$ads['fromdate'] = strtotime($ads['fromdate']);
		$ads['todate'] = strtotime($ads['todate']);
		$this->db->insert($this->table, $ads);
		$adsid = $this->db->insert_id();
		if($adsid)
		{
			$this->db->query("UPDATE ".DB_PRE."ads_place SET `items`=`items`+1 WHERE placeid=$ads[placeid]");
			return $adsid;
		}
	}

	function edit($ads, $adsid, $username = '')
	{
		if(!$this->check_form($ads)) return FALSE;
		$this->adsid = intval($adsid);
		$ads = $this->check_form($ads);
		if(defined('IN_ADMIN'))
		{
			$ads['fromdate'] = strtotime($ads['fromdate']);
			$ads['todate'] = strtotime($ads['todate']);
		}
		$where = ' adsid='.$this->adsid;
		if($username) $where .= " AND username='$username'";

		return $this->db->update($this->table, $ads, $where);
	}

	function manage($offset, $pagesize)
	{
		$offset = intval($offset);
		$pagesize = intval($pagesize);
		$now_time = time();
		return $this->db->select("SELECT * FROM $this->table WHERE 1 $this->sql ORDER BY adsid LIMIT $offset, $pagesize");
	}

	function get_info($adsid, $username = '')
	{
		$adsid = intval($adsid);
		$this->adsid = $adsid;
		if($username) $sql = " AND a.username='$username'";
		return $this->db->get_one("SELECT a.introduce AS ads_introduce,a.*, p.* FROM $this->table as a left join ".DB_PRE."ads_place as p on (a.placeid=p.placeid)  WHERE a.adsid=$this->adsid $sql ");
	}

	function upload($field)
	{
		global $M, $attachment;
		$alowexts = $M['ext'] ? $M['ext'] : 'jpg|jpeg|gif|bmp|png|swf';
		$maxsize = $M['maxsize'] ? intval($M['maxsize']) : 307200;
		$attachment->upload($field, $alowexts, $maxsize);
		return $attachment->uploadedfiles[0]['filepath'];
	}

	function delete($arrid, $username = '')
	{
		if($username) $where = " AND username='$username'";
		if(is_array($arrid))
		{
            $arrid = array_map('intval',$arrid);
			foreach($arrid as $id)
			{
				$r = $this->db->get_one("SELECT placeid FROM ".DB_PRE."ads WHERE adsid=$id $where ");
				$this->db->query("DELETE FROM $this->table WHERE adsid=$id $where ");
				$this->db->query("UPDATE ".DB_PRE."ads_place SET `items`=items-1 WHERE placeid=$r[placeid]");
			}
		}
		else
		{
			$id = intval($arrid);
			$r = $this->db->get_one("SELECT placeid FROM ".DB_PRE."ads WHERE adsid=$id $where ");
			$this->db->query("DELETE FROM $this->table WHERE adsid=$id $where ");
			$this->db->query("UPDATE ".DB_PRE."ads_place SET `items`=items-1 WHERE placeid=$r[placeid]");
		}
		return TRUE;
	}

	function update($arrid, $val)
	{
		$val = intval($val);
		if(is_array($arrid))
		{
			$ids = implode(',', $arrid);
		}
		else
		{
			$ids = intval($arrid);
		}
		$this->db->query("UPDATE $this->table SET passed=$val WHERE adsid IN ($ids)");
		return TRUE;
	}

	function page($page = 1, $expired = 1, $adsplaceid = 0, $pagesize = 15,  $username = '',$status = '',$passid='')
	{
		$page = $page ? intval($page) : 1;
		$expired = $expired ? intval($expired) : 1;
		$adsplaceid = $adsplaceid ? intval($adsplaceid) : 0;
		$pagesize = $M['pagesize'] ? intval($M['pagesize']) : 15;
		$now_time = time();
		$sql = '';
        if($status) $sql .= ' AND status='.$status;
        if($passid) $sql .= ' AND passed='.$passid;
		if($adsplaceid != '0') $sql .= ' AND placeid='.$adsplaceid;
		if($expired=='3') $sql .= ' AND fromdate>'.$now_time;
		if($expired=='1') $sql .= " AND fromdate<=$now_time AND todate>=$now_time";
		if($expired=='2') $sql .= ' AND todate<'.$now_time;
		if($username)
		{
			$sql .= " AND username='$username'";
		}
		$this->sql = $sql;
        $result=$this->db->query("SELECT count(*) as num FROM ".DB_PRE."ads WHERE 1 $this->sql");
		$r=$this->db->fetch_array($result);
		$number=$r['num'];
		return pages($number,$page,$pagesize);
	}

	function status($arrid, $val, $username = '')
	{
		$val = intval($val);
		if(!$username) return FALSE;
		if(is_array($arrid))
		{
			$ids = implode(',', $arrid);
		}
		else
		{
			$ids = intval($arrid);
		}
		$this->db->query("UPDATE $this->table SET status=$val WHERE adsid IN ($ids) AND username='$username'");
		return TRUE;
	}

	function view($adsid, $username = '')
	{
		$adsid = intval($adsid);
		$this->adsid = $adsid;
		$ads = $this->get_info($this->adsid, $username);
		if(empty($ads)) exit("document.write(\"在此位置上没有广告！\")");

		$template = $ads_info['template'] ? $ads_info['template'] : 'ads';
		$contents[] = ads_content($ads);
		$template = $ads['template'] ? $ads['template'] : "ads";
		include template('ads', $template);
	}

	function get_places()
	{
		$place = array();
		$places = array();
		$places = array('0'=>'选择广告位');
		$place = $this->db->select("SELECT placeid, placename FROM ".DB_PRE."ads_place ORDER BY placeid", 'placeid');
        foreach($place as $key => $value)
		{
			foreach($value as $v)
			{
				$places[$key] = $v;
			}
		}
		return $places;
	}

	function check_ads_name($ads_name)
	{
		if(strlen($ads_name)<2 || strlen($ads_name)>30)
		{
			$this->errormsg = 'invalid_name';
			return FALSE;
		}
		return TRUE;
	}

	function stat($id, $typeid, $from = 0, $end = 0)
	{
		$id = intval($id);
		$typeid = intval($typeid);
		if($from)
		{
			$from = strtotime($from);
			$date = "AND clicktime>=$from";
		}
		if($end)
		{
			$end = strtotime($end);
			$date .= " AND clicktime<=$end";
		}
		if(!$id) return FALSE;
		if($typeid==3) $where = "AND username!=''";
		if($typeid==4) $where = "AND referer!=''";
		switch($typeid){
			case '1'://根据AREA
				$field='area';
			break;
			case '2'://根据IP
				$field='ip';
			break;
			case '3'://根据username
				$field='username';
			break;
			case '4':
				$field='referer';
		}
		$stat_ads[0] = $this->db->select("SELECT *, COUNT($field) AS num FROM $this->stat_table WHERE adsid=$id $where $date AND type=1 GROUP BY $field ORDER BY num DESC");
		$stat_ads[1] = $this->db->select("SELECT *, COUNT($field) AS num FROM $this->stat_table WHERE adsid=$id $where $date AND type=0 GROUP BY $field ORDER BY num DESC");
		return $stat_ads;
	}

	function updatearea($adsid)
	{
		$adsid = intval($adsid);
		if(!$adsid) return FALSE;
		require 'ip_area.class.php';
		$ip_area = new ip_area();
		$res = $this->db->query("SELECT id, ip FROM $this->stat_table WHERE adsid=$adsid AND area=''");
		while($r=$this->db->fetch_array($res))
		{
			$area = $ip_area->get($r['ip']);
			$this->db->query("UPDATE $this->stat_table SET area='$area' WHERE id=$r[id]");
		}
		return true;
	}

	function msg()
	{
		global $LANG;
		return $LANG[$this->errormsg];
	}
}
?>