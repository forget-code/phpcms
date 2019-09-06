<?php
class order
{
	var $db;
	var $table;
	var $table_deliver;
    var $table_log;
    var $STATUS;

	function __construct()
	{
		global $db, $_userid, $_username, $_amount;
		$this->db = &$db;
		$this->table = DB_PRE.'order';
        $this->table_log = DB_PRE.'order_log';
		$this->userid = $_userid;
		$this->username = $_username;
		$this->amount = $_amount;
		$this->STATUS = include dirname(__FILE__).'/status.inc.php';
		$this->where_userid = defined('IN_ADMIN') ? '' : "AND `userid`=$this->userid ";
	}

	function order()
	{
		$this->__construct();
	}

	function get($orderid, $fields = '*')
	{
		$orderid = intval($orderid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `orderid`=$orderid $this->where_userid");
	}

	function add($data)
	{
		if(!is_array($data)) return false;
		extract($data);
		if(!$goodsid || !$goodsname || !is_numeric($price) || $price < 0 || $number < 1 || (isset($carriage) && !empty($carriage) && !is_numeric($carriage))) return false;
		$date = date('Y-m-d', TIME);
		$price = round($price, 2);
		$number = intval($number);
		$carriage = round($carriage, 2);
		$amount = $price*$number + $carriage;
		$this->db->query("INSERT INTO `$this->table`(`goodsid`, `goodsname`, `goodsurl`, `unit`, `price`, `number`, `carriage`, `amount`, `consignee`, `areaid`, `telephone`, `mobile`, `address`, `postcode`, `note`, `userid`, `username`, `ip`, `time`, `date`, `status`) VALUES('$goodsid', '$goodsname', '$goodsurl', '$unit', '$price', '$number', '$carriage', '$amount', '$consignee', '$areaid', '$telephone', '$mobile', '$address', '$postcode', '$note', '$this->userid', '$this->username', '".IP."', '".TIME."', '$date', '0')");
		$this->orderid = $this->db->insert_id();
		$this->set_log($this->orderid, 0, 0, '下单');
		return $this->orderid;
	}

	function edit($orderid, $data)
	{
        $r = $this->db->get_one("SELECT `status` FROM `$this->table` WHERE `orderid`=$orderid $this->where_userid");
		if(!$r) return false;
		$laststatus = $status = $r['status'];
		extract($data);
		if(!is_numeric($price) || !is_numeric($number) || !is_numeric($carriage)) return false;
		$amount = $price*$number+$carriage;
		$this->db->query("UPDATE `$this->table` SET `price`='$price', `number`='$number', `carriage`='$carriage', `amount`='$amount' WHERE `orderid`=$orderid $this->where_userid");
		$this->set_log($orderid, $laststatus, $status, "修改订单，price：$price, number：$number, carriage：$carriage, amount：$amount");
		return true;
	}

	function listinfo($where = '', $order = '`orderid` DESC', $page = 1, $pagesize = 20)
	{
		global $units;
		if(defined('IN_ADMIN'))
		{
			if($where) $where = " WHERE $where";
		}
		else
		{
			$where = $where ? " WHERE $where $this->where_userid " : " WHERE ".substr($this->where_userid, 3);
		}
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
        $number = cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
        $this->pages = pages($number, $page, $pagesize);
		$data = $this->db->select("SELECT * FROM `$this->table` $where $order $limit");
		foreach($data as $k=>$v)
		{
			$data[$k]['statusname'] = $this->STATUS[$v['status']];
		}
		return $data;
	}

	function set_status($orderid, $status, $note = '')
	{
		global $CATEGORY,$MODEL;
		$orderid = intval($orderid);
		$status = intval($status);
		if(!isset($this->STATUS[$status])) return false;
		$order = $this->db->get_one("SELECT `goodsid`,`status`,`number` FROM `$this->table` WHERE `orderid`=$orderid $this->where_userid");
		if(!$order || $order['status'] == $status) return false;
        $this->db->query("UPDATE `$this->table` SET `status`=$status WHERE `orderid`=$orderid $this->where_userid");
		if($this->db->affected_rows() == 0) return false;
		if($status == 2 && substr($order['goodsid'],0,8) == 'content_')
		{
			$contentid = substr($order['goodsid'],8);
			$r = $this->db->get_one("SELECT `catid` FROM `".DB_PRE."content` WHERE contentid=$contentid LIMIT 1");
			if($r)
			{
				$modelid = $CATEGORY[$r['catid']]['modelid'];
				$table_content_name = DB_PRE.'c_'.$MODEL[$modelid]['tablename'];
				if($this->db->field_exists($table_content_name, 'stock')) $this->db->query("UPDATE `$table_content_name` SET stock=stock-".$order['number']." WHERE contentid=$contentid");
			}
		}
		$laststatus = $order['status'];
		$note = str_cut($note, 255);
		$this->db->query("INSERT INTO `$this->table_log`(`orderid`, `laststatus`, `status`, `note`, `userid`, `username`, `ip`, `time`) VALUES('$orderid', '$laststatus', '$status', '$note', '$this->userid', '$this->username', '".IP."', '".TIME."')");
		return true;
	}

	function get_closedtime($ordertime, $maxclosedday)
	{
		$time = $ordertime+$maxclosedday*86400-TIME;
		if($time < 0) return false;
		$d = floor($time/86400);
		$h = floor(($time%86400)/3600);
		$m = floor(($time%3600)/60);
		$s = floor($time%60);
		return array('d'=>$d, 'h'=>$h, 'm'=>$m, 's'=>$s);
	}

	function delete($orderid)
	{
		if(!$orderid) return false;
		$orderid = is_array($orderid) ? implodeids($orderid) : intval($orderid);
        $where = is_int($orderid) ? " `orderid`=$orderid " : " `orderid` IN($orderid)";
        $this->db->query("DELETE FROM `$this->table` WHERE $where");
		return true;
	}

	function get_memo($orderid, $memo)
	{
        $r = $this->db->get_one("SELECT `memo` FROM `$this->table` WHERE `orderid`=$orderid $this->where_userid");
		return $r ? $r['memo'] : false;
	}

	function set_memo($orderid, $memo)
	{
		$memo = str_cut($memo, 255);
        $this->db->query("UPDATE `$this->table` SET `memo`='$memo' WHERE `orderid`=$orderid $this->where_userid");
		return true;
	}

	function set_log($orderid, $laststatus, $status, $note = '')
	{
		$note = str_cut($note, 255);
		$this->db->query("INSERT INTO `$this->table_log`(`orderid`, `laststatus`, `status`, `note`, `userid`, `username`, `ip`, `time`) VALUES('$orderid', '$laststatus', '$status', '$note', '$this->userid', '$this->username', '".IP."', '".TIME."')");
		return true;
	}

	function get_log($orderid)
	{
		$orderid = intval($orderid);
        return $this->db->select("SELECT * FROM `$this->table_log` WHERE `orderid`=$orderid ORDER BY `logid`");
	}

	function count($status, $y , $m = 0, $d = 0)
	{
		$status = intval($status);
		$date = '';
		if($m) $date .= $y.'-'.str_pad($m, 2, '0', STR_PAD_LEFT);
		if($d) $date .= '-'.str_pad($d, 2, '0', STR_PAD_LEFT);
		$where = $d ? "AND `date`='$date'" : "AND `date` like '$date%'";
		return cache_count("SELECT SUM(amount) AS `count` FROM `$this->table` WHERE `status`=$status $where");
	}
}
?>