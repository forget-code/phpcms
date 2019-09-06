<?php
class video
{
	var $db;
	var $table;
	var $table_log;
	var $table_data;
	var $table_category;
	var $ishtml = 0;
	var $userid = 0;
	var $userid_sql = '';
	var $pages;
	var $number;
	var $url;
	var $html;
	var $s;
	var $is_update_related = 1;

    function __construct()
    {
		global $db,$MODULE,$modelid;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->table = DB_PRE.'video';
		$this->table_data = DB_PRE.'video_data';
		$this->table_count = DB_PRE.'video_count';
		$this->table_position = DB_PRE.'video_position';
		$this->table_tag = DB_PRE.'video_tag';
		$this->table_category = DB_PRE.'category';

    }

	function video()
	{
		$this->__construct();
	}

	function set_userid($userid)
	{
		$this->userid = intval($userid);
		$this->userid_sql = " AND $this->table.`userid`=$this->userid ";
	}

	function get($vid, $tablecount = 2)
	{
		$vid = intval($vid);
		$data = $this->db->get_one("SELECT * FROM `$this->table` WHERE `vid`=$vid $this->userid_sql");
		if($data)
		{
			if($tablecount >= 2)
			{
				$data2 = $this->db->get_one("SELECT * FROM `$this->table_data` WHERE `vid`=$vid");
				if($tablecount == 2 && is_array($data) && is_array($data2)) $data = array_merge($data, $data2);
			}
			if($tablecount == 3)
			{
				$data3 = $this->db->get_one("SELECT * FROM `$this->table_count` WHERE `vid`=$vid");
				if(is_array($data) && is_array($data2) && is_array($data3)) $data = array_merge($data, $data2, $data3);
			}
		}
		return $data;
	}

	function add($data)
	{
		global $_userid, $_username,$CATEGORY, $MODEL;
		require_once CACHE_MODEL_PATH.'video_input.class.php';
        require_once CACHE_MODEL_PATH.'video_update.class.php';
        
		$model_input = new model_input($this->modelid);
		$inputinfo = $model_input->get($data);
		$systeminfo = $inputinfo['system'];

		$modelinfo = $inputinfo['model'];
		if(!$systeminfo['username']) $systeminfo['username'] = $_username;
		if(!$systeminfo['userid']) $systeminfo['userid'] = $_userid;

		if($data['inputtime'])
		{
			$systeminfo['inputtime'] = strtotime($data['inputtime']);
		}
		else
		{
			$systeminfo['inputtime'] = TIME;
		}
		if($data['updatetime'])
		{
			$systeminfo['updatetime'] = strtotime($data['updatetime']);
		}
		else
		{
			$systeminfo['updatetime'] = TIME;
		}
		if(isset($data['paginationtype']))
		{
			$modelinfo['paginationtype'] = $data['paginationtype'];
			$modelinfo['maxcharperpage'] = $data['maxcharperpage'];
		}
		
		$this->db->insert($this->table, $systeminfo);
		
		$vid = $this->db->insert_id();
        $modelinfo['vid'] = $vid;
		$this->db->insert($this->table_data, $modelinfo);
		
		if($data['islink']==1)
		{
			$url = $data['linkurl'];
			 $this->db->query("UPDATE `$this->table` SET `url`='$url' WHERE `vid`=$vid");
		}
        $this->db->query("UPDATE `$this->table_category` SET `items`=`items`+1 WHERE `catid`='".$data['catid']."'");
		$this->db->query("INSERT INTO `$this->table_count`(`vid`) VALUES('$vid')");

		$content_update = new model_update($this->modelid, $vid);
		$content_update->update($data);
		return $vid;
	}

	function edit($vid, $data)
	{
		global $MODEL,$PHPCMS,$modelid;
		require_once CACHE_MODEL_PATH.'video_input.class.php';
        require_once CACHE_MODEL_PATH.'video_update.class.php';

		$model_input = new model_input($modelid);
		$inputinfo = $model_input->get($data);
		$systeminfo = $inputinfo['system'];
		$modelinfo = $inputinfo['model'];
		if($data['inputtime'])
		{
			$systeminfo['inputtime'] = strtotime($data['inputtime']);
		}
		else
		{
			$systeminfo['inputtime'] = TIME;
		}
		$systeminfo['updatetime'] = TIME;
		
		if($data['islink']==1)
		{
			$systeminfo['url'] = $data['linkurl'];
		}
		$this->db->update($this->table, $systeminfo, "`vid`=$vid $this->userid_sql");
		unset($systeminfo['status']);

		if($modelinfo) $this->db->update($this->table_data, $modelinfo, "`vid`=$vid");

		$model_update = new model_update($modelid, $vid);
		$model_update->update($data);

		return true;
	}

	function listinfo($where = '', $order = '`listorder` DESC,`vid` DESC', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where $this->userid_sql";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
        $number = cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		//echo "SELECT * FROM `$this->table` $where $order $limit";
		$result = $this->db->query("SELECT * FROM `$this->table` $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
		    $r['inputtime'] = $r['inputtime'];
		    $r['updatetime'] = $r['updatetime'];
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE `$this->table` SET `listorder`=$listorder WHERE `vid`=$id $this->userid_sql");
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

    function vid($vid, $userid = 0, $allow_status = array())
    {
		$where = "`vid` IN(".implodeids($vid).")";
		$where .= $allow_status ? " AND `status` IN(".implodeids($allow_status).")" : '';
		$where .=  $this->userid_sql;
		$array = array();
		$result = $this->db->query("SELECT `vid` FROM `$this->table` WHERE $where");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r['vid'];
		}
        $this->db->free_result($result);
		return is_array($vid) ? $array : $array[0];
    }

	function delete($vid)
	{
		global $MODULE,$attachment;
		if(is_array($vid))
		{
			array_map(array(&$this, 'delete'), $vid);
		}
		else
		{
			$vid = intval($vid);
			$data = $this->db->get_one("SELECT `catid`,`url`,`searchid` FROM `$this->table` WHERE `vid`=$vid $this->userid_sql");
			if($data)
			{
				$this->set_catid($data['catid']);
				if($this->ishtml) 
				{
					$html = load('html.class.php');
					$html->delete($vid, $this->table_data);
				}
				$this->db->query("DELETE `$this->table`,`$this->table_data` FROM `$this->table`,`$this->table_data` WHERE $this->table.vid=$this->table_data.vid AND $this->table.vid=$vid $this->userid_sql");
                $this->db->query("UPDATE `$this->table_category` SET `items`=`items`-1 WHERE `catid`='".$data['catid']."'");
				if($this->db->affected_rows())
				{
					$this->db->query("DELETE FROM `$this->table_count` WHERE `vid`=$vid");
					$this->db->query("DELETE FROM `$this->table_position` WHERE `vid`=$vid");
					$this->db->query("DELETE FROM `$this->table_tag` WHERE `vid`=$vid");
					if(!is_object($attachment))
					{
						require_once 'attachment.class.php';
						$attachment = new attachment('video', $data['catid']);
					}
					$attachment->delete("`vid`=$vid");

					if(isset($MODULE['comment']))
					{
						$this->db->query("DELETE FROM `".DB_PRE."comment` WHERE keyid='video-video-title-$vid'");
					}
				}
				$this->log_write($vid, 'delete');
			}
		}
		return true;
	}

	function clear()
	{
		@set_time_limit(600);
		$result = $this->db->query("SELECT `vid` FROM `$this->table` WHERE `status`=0");
		while($r = $this->db->fetch_array($result))
		{
			$this->delete($r['vid']);
		}
        $this->db->free_result($result);
		return true;
	}

	function restore($vid)
	{
		return $this->status($vid, 99);
	}

	function restoreall()
	{
		@set_time_limit(600);
		$result = $this->db->query("SELECT `vid` FROM `$this->table` WHERE `status`=0");
		while($r = $this->db->fetch_array($result))
		{
			$this->status($r['vid'], 99);
		}
        $this->db->free_result($result);
		return true;
	}

	function count($where = '')
	{
		if($where) $where = " WHERE $where $this->userid_sql";
		return cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
	}

	function get_count($vid)
	{
		$vid = intval($vid);
		return $this->db->get_one("SELECT * FROM `$this->table_count` WHERE `vid`=$vid");
	}

	function status($vid, $status)
	{
		global $MODULE, $presentpoint,$catid;
		if(!$vid) return false;
		$status = intval($status);
		$vids = implodeids($vid);
		$is_update = $this->db->query("UPDATE `$this->table` SET `status`=$status WHERE `vid` IN($vids) $this->userid_sql");
		if(is_array($vid))
		{
			foreach($vid as $id)
			{
				if($status==99 && isset($MODULE['pay']))
				{
					$cinfo = $this->get($id);
					$r = $this->db->get_one("SELECT setting FROM `".DB_PRE."category` WHERE `catid`='$cinfo[catid]'");
					$setting = string2array($r['setting']);
					$presentpoint = $setting['presentpoint'];
					$catid = $cinfo['catid'];
					if($catid && $presentpoint)
					{
						$api_msg = $presentpoint > 0 ? '投稿奖励' : '发布信息扣点';
						if(!is_object($pay_api)) $pay_api = load('pay_api.class.php', 'pay', 'api');
						$pay_api->update_exchange('video', 'point', $presentpoint, $api_msg, $cinfo['userid']);
					}
				}
			}
		}
		return $is_update;
	}

	function get_vid($title)
	{
		$info = $this->db->get_one("SELECT `vid` FROM `$this->table` WHERE `title`='$title'");
		if($info['vid']) return TRUE;
		else return FALSE;
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
			$r = $this->db->select("SELECT `vid` FROM `$this->table` WHERE `catid` IN ($ids)", 'vid');
			$vids = array_keys($r);
			array_map(array($this, 'move'), $vids, array_fill(0, count($vids), $targetcatid));
		}
		else
		{
			if(strpos($id, ',')!==false)
			{
				$vids = explode(',', $id);
				array_map(array($this, 'move'), $vids, array_fill(0, count($vids), $targetcatid));
			}
			$vid = intval($id);
			$r = $this->db->get_one("SELECT `catid`, `islink` FROM `$this->table` WHERE `vid`=$vid");
			$this->db->query("UPDATE `$this->table_category` SET `items`=`items`-1 WHERE `catid`=$r[catid]");
			$this->set_catid($r['catid']);
			if($this->ishtml && !$r['islink'])
			{
				if(!is_object($html))
				{
					$html = load('html.class.php');
				}
				$html->delete($vid, $this->table_data);
			}
			$this->db->query("UPDATE `$this->table` SET `catid`='$targetcatid' WHERE `vid`=$vid");
			$info = $this->url->show($vid, 0, $targetcatid);
			$this->db->query("UPDATE `$this->table` SET `url`='$info[1]' WHERE `vid`=$vid");
			$this->db->query("UPDATE `$this->table_category` SET `items`=`items`+1 WHERE `catid`=$targetcatid");
			$this->log_write($vid);
		}
		return true;
	}

	function get_posid($vid = 0, $posid = 0)
	{
		return $this->db->get_one("SELECT * FROM `".DB_PRE."video_position` WHERE `vid`=$vid AND `posid`=$posid");
	}

	function add_posid($vid = 0, $posid = 0)
	{
		$vid = intval($vid);
		$posid = intval($posid);
		if(!$vid || !$posid) return false;
		$this->db->query("INSERT INTO `".DB_PRE."video_position` (`vid`, `posid`) VALUES ('$vid', '$posid')");
		$this->db->query("UPDATE $this->table SET `posids`=1 WHERE `vid`=$vid");
		return true;
	}
	
	function update_ku6vid($vid,$ku6vid)
	{
		$this->db->query("UPDATE $this->table_data SET `vmsvid`='$ku6vid' WHERE `vid`=$vid");
		return true;
	}

	function update_thumb($vid,$thumb)
	{
		$this->db->query("UPDATE $this->table SET `thumb`='$thumb' WHERE `vid`=$vid");
		return true;
	}

	function get_comment_number($vid)
	{
		$keyid = "video-video-title-".$vid;
        $r = $this->db->get_one("SELECT COUNT(*) AS num FROM `".DB_PRE."comment` WHERE `keyid` = '$keyid'");
		return $r['num'];
	}
}
?>