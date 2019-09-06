<?php
	defined('IN_PHPCMS') or exit('Access Denied');
	if (!class_exists('message'))
	{
		require_once MOD_ROOT.'include/message.class.php';
	}

	class message_admin extends message
	{	
		function list_message($where, $order = '', $page = 1, $pagesize = 100)
		{
			$arr_messages = $this->_listinfo($where, $order, $page, $pagesize);
			return $arr_messages;
		}

		/**
		 * 删除短消息方法
		 *
		 * @param ARRAY INT $msgid
		 * @return 返回删掉的消息树
		 */
		function delete($msgid)
		{
			if(empty($msgid) || !isset($msgid))
			{
				$this->msg = 'msgid_is_null';
				return false;
			}
			$msgid = array_map("intval", $msgid);
			$msgid = implode(',', $msgid);
			$sql = "DELETE FROM $this->table WHERE messageid IN ($msgid)";
			if($msgid) $this->db->query($sql);
			return $this->db->affected_rows();
		}
		
		/**
		 * 统计收件箱里共有多少短消息
		 *
		 * @return $num_inbox
		 */
		function num_inbox()
		{
			$num_inbox = $this->count_message($where=" folder='inbox'");
			return $num_inbox;
		}
		
		/**
		 * 统计发件箱里共有多少短消息
		 *
		 * @return $num_outbox
		 */
		function num_outbox()
		{
			$num_outbox = $this->count_message($where=" folder='outbox'");
			return $num_outbox;
		}
		
		/**
		 * 清空短消息
		 *
		 * @return unknown
		 */
		function truncat()
		{
			$sql = "TRUNCATE TABLE $this->table";
			return $this->db->query($sql);
		}
		
		/**
		 * 按时间删除短消息
		 *
		 * @param unknown_type $time
		 */
		function del_by_time($time)
		{
			$time = intval($time);
			if($time == 1)
			{
				$this->truncat();
				return true;
			}
			$time = time() - $time * 24 * 60 * 60;
			$arr_msgid = $this->_listinfo($where = " message_time < $time");
			
			foreach ($arr_msgid as $msgid) 
			{
				if(!$this->delete($msgid['messageid'])) return false;
			}
			return true;
		}
	}
?>