<?php
	class message_api
	{
		var $db;
		var $table;
		
		function __construct()
		{
			global $db;
			$this->db = &$db;
			$this->table = DB_PRE.'message';	
		}
		
		function message_api()
		{
			$this->__construct();
		}

		function count_message($userid, $status = '')
		{
			$userid = intval($userid);
			if($userid < 1) return false;
			if($status == 'inbox')
			{
				$where = " send_to_id='$userid' AND (folder='inbox' OR folder='all') AND replyid=0";
			}
			elseif($status == 'outbox')
			{
				$where = " send_from_id='$userid' AND (folder='outbox' OR folder='all')";
			}
			elseif($status == 'total')
			{
				$where = " (send_to_id='$userid' AND folder='inbox' AND replyid=0) OR (send_from_id='$userid' AND folder='outbox')";
			}
			elseif($status == 'new')
			{
				$where = " (status=1 AND send_to_id=$userid) OR (status=2 AND send_from_id=$userid)";
			}
			else
			{
				$where = " send_to_id = '$userid' AND status=1";
			}
			$num = $this->db->get_one("SELECT COUNT(messageid) as number FROM $this->table WHERE $where");
			return $num['number'];
		}
	}
?>