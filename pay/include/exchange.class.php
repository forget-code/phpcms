<?php
class exchange
{
	var $logs_table = '';
	var $db = '';
	var $lang ;
    var $default_sort = '';
	function exchange()
	{
		global $db , $LANG;
		$this->lang = $LANG;
        $this->default_sort = 'id';
		$this->db = $db;
		$this->table_exchange = DB_PRE.'pay_exchange';
	}

	function get_list( $condition = null, $page = 1, $pagesize)
	{
        global $MODULE , $_userid;
		$userid = intval($_userid);
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
		$exchange = array();
        $arg['where'] = $this->_make_condition($condition);
		$exchange['num'] = $this->db->get_one("SELECT COUNT(*) AS number FROM `$this->table_exchange` WHERE `userid` = '{$userid}' {$arg['where']} ");
		$exchange['pages'] = pages($exchange['num']['number'], $page, $pagesize);
		$sql = "SELECT * FROM `$this->table_exchange` WHERE `userid` = '{$userid}' {$arg['where']} ";
        $sql .= " ORDER BY `id` DESC LIMIT $offset,$pagesize";
		$result = $this->db->query($sql);
		while($r = $this->db->fetch_array($result))
        {
            if($r['number'] >=0)
            {
                $r['type_type'] = $this->lang['in_'.$r['type']];
                if($r['type'] == 'point')
                {
                    $r['number'] = intval($r['number']).' '.$this->lang['unit_'.$r['type']];
                }
                else
                {
                    $r['number'] = $r['number'].' '.$this->lang['unit_'.$r['type']];
                }
            }
            else
            {
                 $r['type_type'] = $this->lang['out_'.$r['type']];
                 if($r['type'] == 'point')
                 {
                    $r['number'] = abs($r['number']);
                    $r['number'] = intval($r['number']).' '.$this->lang['unit_'.$r['type']];
                 }
                 else
                 {
                     $r['number'] = abs($r['number']).' '.$this->lang['unit_'.$r['type']];
                 }
            }
			$r['type'] = $this->lang[$r['type']];
			$exchange['info'][] = $r;
        }
		return $exchange;
	}

	function _make_condition($conditions)
	{
		$where = '';
		if(is_array($conditions))
        {
			$where .= implode(' AND ', $conditions);
		}
		if ($where)
        {
			return ' AND ' . $where;
		}
	}
}
?>