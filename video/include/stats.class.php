<?php
class stats
{
	var $db;
	var $table;
	var $table_count;
	var $pages;
	var $number;

    function __construct()
    {
		global $db,$MODULE,$modelid;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->table = DB_PRE.'video';
		$this->table_count = DB_PRE.'video_count';
    }

	function stats()
	{
		$this->__construct();
	}

	function listinfo($where = '', $order = 'a.`vid` DESC', $page = 1, $pagesize = 50)
	{
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
        $number = cache_count("SELECT count(*) AS `count` FROM `$this->table` a,`$this->table_count` b WHERE a.vid=b.vid $where");
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` a, `$this->table_count` b WHERE a.vid=b.vid $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function hits($vid)
	{
		$vid = intval($vid);
		$r = $this->db->get_one("SELECT * FROM `$this->table_count` WHERE `vid`=$vid");
		if(!$r) return false;
		if(date('Ymd',$r['hits_time']) < date('Ymd', TIME)) {
			$hits_yestoday = $r['hits_day'];
		} else {
			$hits_yestoday = $r['hits_yestoday'];
		}
		$hits = $r['hits'] + 1;
		$hits_day = (date('Ymd', $r['hits_time']) == date('Ymd', TIME)) ? ($r['hits_day'] + 1) : 1;
		$hits_week = (date('YW', $r['hits_time']) == date('YW', TIME)) ? ($r['hits_week'] + 1) : 1;
		$hits_month = (date('Ym', $r['hits_time']) == date('Ym', TIME)) ? ($r['hits_month'] + 1) : 1;
        return $this->db->query("UPDATE `$this->table_count` SET `hits`=$hits,`hits_day`=$hits_day,`hits_yestoday`=$hits_yestoday,`hits_week`=$hits_week,`hits_month`=$hits_month,`hits_time`=".TIME." WHERE `vid`=$vid");
	}
}
?>