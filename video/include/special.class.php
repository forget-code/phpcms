<?php
class special
{
	var $db;
	var $pages;
	var $number;
	var $table;
    var $contentpages;

    function __construct()
    {
		global $db,$M;
		$this->db = &$db;
		$this->table = DB_PRE.'video_special';
		$this->table_video = DB_PRE.'video';
        $this->table_video_list = DB_PRE.'video_special_list';
		$this->M = $M;
    }

	function special()
	{
		$this->__construct();
	}

	function get($specialid)
	{
		$specialid = intval($specialid);
		if($specialid < 1) return false;
		return $this->db->get_one("SELECT * FROM $this->table WHERE specialid=$specialid");
	}
	
	function get_specialid($vid)
	{
		$vid = intval($vid);
		if($vid < 1) return false;
		$r = $this->db->get_one("SELECT * FROM $this->table_video_list WHERE vid=$vid");
		if($r)
		{
			return $r['specialid'];
		}
		else
		{
			return false;
		}
	}

	function add($info)
	{
		global $_userid,$_username;
		if(!is_array($info) || empty($info['title'])) return false;
        $info['addtime'] = TIME;
        $info['userid'] = $_userid;
        $info['username'] = $_username;
		$this->db->insert($this->table, $info);
		$specialid = $this->db->insert_id();
		return $specialid;
	}

	function edit($specialid, $info)
	{
		if(!$specialid || !is_array($info) || empty($info['title'])) return false;
		return $this->db->update($this->table, $info, "specialid=$specialid");
	}

	function delete($specialid)
	{
		$specialid = intval($specialid);
		return $this->db->query("DELETE FROM $this->table WHERE specialid=$specialid");
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM $this->table $where");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}
	
    function list_content($specialid, $page = 1, $pagesize = 50,$urlrule='')
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM `$this->table_video` AS a ,`$this->table_video_list` AS b WHERE a.vid = b.vid AND b.specialid = '$specialid'");
        $number = $r['number'];
		
        $this->contentpages = pages($number, $page, $pagesize,$urlrule);
		return $this->db->select("SELECT * FROM `$this->table_video` AS a ,`$this->table_video_list` AS b WHERE a.vid = b.vid AND b.specialid = '$specialid' ORDER BY b.listorder ASC,b.vid DESC $limit");
	}
	
	function video_ajax_pages($specialid, $page = 1, $pagesize = 50)
	{
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM `$this->table_video` AS a ,`$this->table_video_list` AS b WHERE a.vid = b.vid AND b.specialid = '$specialid'");
        $number = $r['number'];
        $this->ajaxpages = special_ajax_page($number, $page, $pagesize,$specialid);
		return $this->db->select("SELECT * FROM `$this->table_video` AS a ,`$this->table_video_list` AS b WHERE a.vid = b.vid AND b.specialid = '$specialid' ORDER BY b.listorder ASC,b.vid DESC $limit");
	}

    function del_content($specialid, $vid)
	{
		$specialid = intval($specialid);
        if(is_array($vid)) $vid = array_map('intval', $vid);
        $vid = implodeids($vid);
		return $this->db->query("DELETE FROM `$this->table_video_list` WHERE specialid=$specialid AND `vid` IN($vid)");
	}
	
	function add_to_special($specialid,$vid)
	{
		if(is_array($vid))
		{
			foreach($vid AS $id)
			{
				$r = $this->db->get_one("SELECT * FROM ".$this->table_video_list." WHERE specialid='$specialid' AND vid='$id'");
				if(!$r)
				{
					$info['specialid'] = $specialid;
					$info['vid'] = $id;
					$this->db->insert($this->table_video_list, $info);
				}
			}
		}
		else
		{
			$r = $this->db->get_one("SELECT * FROM ".$this->table_video_list." WHERE specialid='$specialid' AND vid='$vid'");
			if(!$r)
			{
				$info['specialid'] = $specialid;
				$info['vid'] = $vid;
				$this->db->insert($this->table_video_list, $info);
			}
		}
		$r = $this->db->get_one("SELECT count(*) as number FROM `$this->table_video_list` WHERE specialid = '$specialid'");
		$this->db->query("UPDATE `$this->table` SET videonums='$r[number]' WHERE specialid = '$specialid'");
		return true;
	}
	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table SET listorder=$listorder WHERE `specialid`=$id");
		}
		return true;
	}

	function elite($specialid, $value)
	{
		$specialid = intval($specialid);
		$value = $value == 1 ? 1: 0;
		return $this->db->query("UPDATE `$this->table` SET `elite`='$value' WHERE `specialid`=$specialid");
	}

	function disable($specialid, $value)
	{
		$specialid = intval($specialid);
		$value = $value == 1 ? 1: 0;
		return $this->db->query("UPDATE `$this->table` SET `disabled`='$value' WHERE `specialid`=$specialid");
	}
	
	function content_listorder($specialid,$info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE $this->table_video_list SET listorder='$listorder' WHERE `specialid`='$specialid' AND vid='$id'");
		}
		return true;
	}
}
?>