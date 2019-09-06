<?php
class ku6video
{
	var $table;
	var $db;

	function __construct()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'ku6video';
	}

	function ku6video()
	{
		$this->__construct();
	}

	function add($info)
	{
		if(!$info['vid']) return false;
		if(!$info['contentid']) return false;
		$this->db->insert($this->table, $info);	
		return true;
	}

	function edit($vid, $info)
	{
		if(!$vid) return false;
		if(!is_array($info)) return false;
		$info['vid'] = $vid;
		$this->db->update($this->table, $info);
		return true;
	}

	function get_contentid($vid)
	{
		$array = $this->db->get_one("SELECT contentid FROM $this->table WHERE vid='$vid'");
		if(!$array) return false;
		return $array['contentid'];
	}

	function get($contentid)
	{
		$contentid = intval($contentid);
		if(!$contentid) return false;
		$info = $this->db->get_one("SELECT * FROM $this->table WHERE contentid=$contentid");
		return $info;
	}

	function status($contentid, $status)
	{
		$contentid = intval($contentid);
		if(!$contentid) return false;
		if(!$status) return false;
		$info = $this->get($contentid);
		$vid = $info['vid'];
		$status = intval($status);
		$arr_stauts = array('contentid'=>$contentid, 'vid'=>$vid, 'vstatus'=>$status);
		$this->db->update($this->table, $arr_stauts);
		return true;
	}

	function delete($vid)
	{
		global $http;
		if(!$vid) return false;	
		if(!is_a($http, 'http'))
		{
			$http = load('http.class.php');
		}
		$arr_post['ku6vid'] = $vid;
		$arr_post['vcode'] = strtoupper(md5($vid.'ku620081217juma'));
		$http->post(KU6_UNION.'uploadflash.php?c=api&a=del', $arr_post);
		$this->db->query("DELETE FROM $this->table WHERE vid='$vid'");
		return true;
	}
}
?>