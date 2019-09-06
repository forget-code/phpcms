<?php
class yp
{
	var $db;
	var $table;
	var $table_category;
	var $table_count;
	var $userid = 0;
	var $userid_sql = '';
	var $pages;
	var $number;
	var $url;
	var $s;
	var $model_type;

    function __construct()
    {
		global $db, $log, $MODULE;
		$this->db = &$db;
    }

	function yp()
	{
		$this->__construct();
	}

	function set_model($table)
	{
		$this->model_type = $table;
		$this->table = DB_PRE.'yp_'.$table;
		$this->table_category = DB_PRE.'category';
		$this->table_count = DB_PRE.'yp_count';
		return true;
	}

	function set_userid($userid)
	{
		$this->userid = intval($userid);
		$this->userid_sql = " AND $this->table.`userid`=$this->userid ";
	}

	function get($id, $tablecount = 2)
	{
		$id = intval($id);
		$data = $this->db->get_one("SELECT * FROM `$this->table` WHERE `id`=$id $this->userid_sql");
		if($data)
		{
			if($tablecount == 2)
			{
				$data2 = $this->db->get_one("SELECT * FROM `$this->table_count` WHERE `id`=$id");
				if(is_array($data) && is_array($data2)) $data = array_merge($data, $data2);
			}
		}
		return $data;
	}

	function add($data)
	{
		global $_userid,$CATEGORY, $MODEL;
		
        if(!$data['catid'] && !in_array($this->model_type,array('job','news'))) return false;
		require_once CACHE_MODEL_PATH.'yp_input.class.php';
        require_once CACHE_MODEL_PATH.'yp_update.class.php';
		$yp_input = new yp_input($this->modelid);

		$inputinfo = $yp_input->get($data);
		$inputinfo['userid'] = $_userid;
		
			if($inputinfo['inputtime'])
			{
				$inputinfo['inputtime'] = strtotime($inputinfo['inputtime']);
			}
			else
			{
				$inputinfo['inputtime'] = TIME;
			}
			if($inputinfo['updatetime'])
			{
				$inputinfo['updatetime'] = strtotime($inputinfo['updatetime']);
			}
			else
			{
				$inputinfo['updatetime'] = TIME;
			}
		$this->db->insert($this->table, $inputinfo);
		$id = $this->db->insert_id();
		
        $modelinfo['id'] = $id;
		if($CATEGORY[$data['catid']]['arrparentid'])
		{
			$arr_catids = substr($CATEGORY[$data['catid']]['arrparentid'],2).','.$data['catid'];
		}
		if($this->model_type=='product')
		{
			$this->db->query("UPDATE `$this->table_category` SET `pitems`=`pitems`+1 WHERE `catid` IN (".$arr_catids.")");
		}
		elseif($this->model_type=='buy')
		{
			$this->db->query("UPDATE `$this->table_category` SET `items`=`items`+1 WHERE `catid` IN (".$arr_catids.")");
		}
		$this->db->query("INSERT INTO `$this->table_count`(`id`,`model`) VALUES('$id','$this->model_type')");
		return $id;
	}

	function edit($id, $data)
	{
		global $MODEL;
		require_once CACHE_MODEL_PATH.'yp_input.class.php';
        require_once CACHE_MODEL_PATH.'yp_update.class.php';

		$content_input = new yp_input($this->modelid);
		$inputinfo = $content_input->get($data);
		$this->db->update($this->table, $inputinfo, "`id`=$id $this->userid_sql");

		$content_update = new yp_update($this->modelid, $id);
		$content_update->update($data);
		return true;
	}

	function listinfo($where = '', $order = '`id` DESC', $page = 1, $pagesize = 30, $table_join = 0)
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
			if($table_join) $ids[$r['userid']] = $r['userid'];
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		if($table_join && $ids)
		{
			$ids = implodeids($ids);
			$result2 = $this->db->query("SELECT `userid`,`companyname`,`sitedomain` FROM ".DB_PRE."member_company WHERE userid IN ($ids)");
			while($rs = $this->db->fetch_array($result2))
			{
				$companydata[$rs['userid']] = $rs;
			}
			foreach($array AS $arr)
			{
				$arr['companyname'] = $companydata[$arr['userid']]['companyname'];
				$arr['sitedomain'] = $companydata[$arr['userid']]['sitedomain'];
				$data[] = $arr;
			}
			return $data;
		}
		else
		{
			return $array;
		}
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE `$this->table` SET `listorder`=$listorder WHERE `id`=$id $this->userid_sql");
		}
		return true;
	}

	function search($sql, $page = 1, $pagesize = 20, $setting = array())
	{
		$page = max(intval($page), 1);
		$offset = $number*($page-1);
		$sql_count = preg_replace("/^SELECT([^(]+)FROM(.+)(ORDER BY.+)$/i", "SELECT COUNT(*) AS `count` FROM\\2", $sql);
		$count = cache_count($sql_count);
		$this->pages = pages($count, $page, $number);
		$data = array();
		$result = $db->query("$sql LIMIT $offset, $number");
		while($r = $db->fetch_array($result))
		{
			$data[] = $r;
		}
		$db->free_result($result);
		return $data;
	}

	function output($data)
	{
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$output = new content_output();
		return $output->get($data);
	}

	function search_api($id)
	{
		global $MODULE,$MODEL,$CATEGORY;
		if(!isset($MODULE['search'])) return false;
		if(!is_object($this->s)) $this->s = load('search.class.php', 'search', 'include');
		$r = $this->get($id);
		if(!$r) return false;
		$modelid = $CATEGORY[$r['catid']]['modelid'];
		if(!$MODEL[$modelid]['enablesearch']) return false;
        $type = $MODEL[$modelid]['tablename'];
		$this->s->set_type($type);
		if($r['searchid'])
		{
			if($r['status'] == 99)
			{
				$fulltext_array = cache_read($modelid.'_fields.inc.php',CACHE_MODEL_PATH);
				foreach($fulltext_array AS $key=>$value)
				{
					if($value['isfulltext']) $fulltextcontent .= $r[$key].' ';
				}
				$this->s->update($r['searchid'], $r['title'], $fulltextcontent, $r['url']);
			}
			else
			{
				$this->s->delete($r['searchid']);
			}
		}
		else
		{
			$fulltext_array = cache_read($modelid.'_fields.inc.php',CACHE_MODEL_PATH);
			foreach($fulltext_array AS $key=>$value)
			{
				if($value['isfulltext']) $fulltextcontent .= $r[$key].' ';
			}
			$searchid = $this->s->add($r['title'], $fulltextcontent, $r['url']);
			if(!$searchid) return false;
            $this->db->query("UPDATE `$this->table` SET `searchid`=$searchid WHERE `id`=$id");
		}
		return true;
	}

    function id($id, $userid = 0, $allow_status = array())
    {
		$where = "`id` IN(".implodeids($id).")";
		$where .= $allow_status ? " AND `status` IN(".implodeids($allow_status).")" : '';
		$where .=  $this->userid_sql;
		$array = array();
		$result = $this->db->query("SELECT `id` FROM `$this->table` WHERE $where");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r['id'];
		}
        $this->db->free_result($result);
		return is_array($id) ? $array : $array[0];
    }

	function delete($id)
	{
		global $attachment;
		//缺少删除内容附件
		if(is_array($id))
		{
			array_map(array(&$this, 'delete'), $id);
		}
		else
		{
			$id = intval($id);
			$this->db->query("DELETE FROM `$this->table` WHERE `id`='$id' $this->userid_sql");
		}
		return true;
	}
	
	function elite($id, $status = 0)
	{
		$status = intval($status);
		if(is_array($id))
		{
			$id = implodeids($id);
			$this->db->query("UPDATE `$this->table` SET `elite`='$status' WHERE `id` IN ($id) $this->userid_sql");
		}
		else
		{
			$this->db->query("UPDATE `$this->table` SET `elite`='$status' WHERE `id`='$id' $this->userid_sql");
		}
		return true;
	}

	function clear()
	{
		@set_time_limit(600);
		$result = $this->db->query("SELECT `id` FROM `$this->table` WHERE `status`=0");
		while($r = $this->db->fetch_array($result))
		{
			$this->delete($r['id']);
		}
        $this->db->free_result($result);
		return true;
	}

	function restore($id)
	{
		return $this->status($id, 99);
	}

	function restoreall()
	{
		@set_time_limit(600);
		$result = $this->db->query("SELECT `id` FROM `$this->table` WHERE `status`=0");
		while($r = $this->db->fetch_array($result))
		{
			$this->status($r['id'], 99);
		}
        $this->db->free_result($result);
		return true;
	}

	function count($where = '')
	{
		if($where) $where = " WHERE $where $this->userid_sql";
		return cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
	}

	function get_count($id)
	{
		$id = intval($id);
		return $this->db->get_one("SELECT * FROM `$this->table_count` WHERE `id`=$id AND `model`='$this->model_type'");
	}

	function hits($id)
	{
		$id = intval($id);
		$r = $this->db->get_one("SELECT * FROM `$this->table_count` WHERE `id`=$id AND `model`='$this->model_type'");
		if(!$r) return false;
		$hits = $r['hits'] + 1;
		$hits_day = (date('Ymd', $r['hits_time']) == date('Ymd', TIME)) ? ($r['hits_day'] + 1) : 1;
		$hits_week = (date('YW', $r['hits_time']) == date('YW', TIME)) ? ($r['hits_week'] + 1) : 1;
		$hits_month = (date('Ym', $r['hits_time']) == date('Ym', TIME)) ? ($r['hits_month'] + 1) : 1;
        return $this->db->query("UPDATE `$this->table_count` SET `hits`=$hits,`hits_day`=$hits_day,`hits_week`=$hits_week,`hits_month`=$hits_month,`hits_time`=".TIME." WHERE `id`=$id AND `model`='$this->model_type'");
	}

	function status($id, $status)
	{
		if(!$id) return false;
		$status = intval($status);
		$ids = implodeids($id);
		$is_update = $this->db->query("UPDATE `$this->table` SET `status`=$status WHERE `id` IN($ids) $this->userid_sql");
		return true;
	}

	function get_status($processid)
	{
		$processid = intval($processid);
		$array = array();
		$result = $this->db->query("SELECT `status` FROM `".DB_PRE."process_status` WHERE `processid`=$processid");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r['status'];
		}
        $this->db->free_result($result);
		return $array;
	}
	function move($id = '', $targetcatid = 0, $iscatid = 0)
	{
		if($iscatid)
		{
			if(!is_array($id)) return false;
			$ids = implode(',',$id);
			$this->db->query("UPDATE $this->table SET catid='$targetcatid' WHERE catid IN($ids)");
		}
		else
		{
			$this->db->query("UPDATE $this->table SET catid='$targetcatid' WHERE id IN ($id)");
		}
		return true;
	}
}
?>