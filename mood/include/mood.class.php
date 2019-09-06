<?php 
class mood
{
	var $db;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'mood';
		$this->table_data = DB_PRE.'mood_data';
    }

	function mood()
	{
		$this->__construct();
	}

	function add($moodid, $id, $vote_id = 0)
	{
		$moodid = intval($moodid);
		$id = intval($id);
		$vote_id = intval($vote_id);
		if($id<0 || $moodid<0) return false;
		$info['moodid'] = $moodid;
		$info['contentid'] = $id;
		$info['updatetime'] = TIME;
		$field = 'n'.$vote_id;
		$r = $this->db->get_one("SELECT * FROM $this->table_data WHERE contentid=$id");
		if(!$r['moodid'])
		{
			$this->db->insert($this->table_data, $info);
		}
		$this->db->query("UPDATE $this->table_data SET total=total+1,$field=$field+1,updatetime=".TIME." WHERE contentid=$id");
		$r['total'] = $r['total']+1;
		$r[$field] = $r[$field]+1;
		return $r;
	}

	function show($id)
	{
		$id = intval($id);
		return $this->db->get_one("SELECT * FROM $this->table_data WHERE moodid=$id");
	}

	function mood_show($moodid)
	{
		$moodid = intval($moodid);
		return $this->db->get_one("SELECT * FROM $this->table WHERE moodid=$moodid");
	}

	function listinfo()
	{
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table ORDER BY moodid DESC");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}
}
?>