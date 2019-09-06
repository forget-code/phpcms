<?php
	class space
	{
		var $table;
		var $api_table;
		var $db;
		var $api;
		var $blockids;

		function __construct()
		{
			global $db;
			$this->table = DB_PRE.'space';
			$this->api_table = DB_PRE.'space_api';
			$this->db = $db;
			$this->api = cache_read('space_api.php');
		}
		
		function space()
		{
			$this->__construct();
		}
		
		/**
		 * 获得单个API信息
		 *
		 * @param INT $apiid
		 * @return $result
		 */
		function get_api($apiid)
		{
			$apiid = intval($apiid);
			if($apiid < 1) return false;
			$result = $this->db->get_one("SELECT * FROM $this->api_table WHERE apiid='$apiid'");
			return $result;
		}
		
		/**
		 * 统计所有API的数目
		 *
		 * @param STRING $where
		 * @return $message_num['number']
		 */
		function count_api($where = '')
		{
			if ($where) $where = 'WHERE '.$where;
			$message_num = $this->db->get_one("SELECT COUNT(apiid) as number FROM $this->api_table $where");
			return $message_num['number'];
		}
		
		/**
		 * 列出所有api信息
		 *
		 * @param STRING $where
		 * @param STRING $order
		 * @param INT $page
		 * @param INT $pagesize
		 * @return unknown
		 */
		function _listinfo_api($where, $order = '', $page = 1, $pagesize = 100)
		{
			$limit = $result = '';
			if($where) $where = "WHERE $where";
			if($order) $order = "ORDER BY $order";
			$page = max(intval($page), 1);
			$offset = $pagesize*($page-1);
			$limit = " LIMIT $offset, $pagesize";
			$array = array();
			$sql = "SELECT * FROM $this->api_table $where $order $limit";
			$result = $this->db->query($sql);
			while ($r = $this->db->fetch_array($result)) 
			{
				$array[] = $r;	
			}
			$this->db->free_result($result);
			return $array;
		}
		
		/**
		 * 获得空间模块的信息
		 *
		 * @param STRING $where
		 * @return $block
		 */
		function get_block($userid)
		{
			$userid = intval($userid);
			$blockinfo = $this->db->get_one("SELECT blockid FROM $this->table WHERE userid=$userid");
			$this->blockids = $blockinfo['blockid'];
			if(!$this->blockids && !$this->activate($userid)) return false;
			$arr_block = explode(',', $this->blockids);
			if(is_array($this->api))
			{
				$block = array_intersect_key($this->api, array_flip($arr_block));
			}
			return $block;
		}
		
		/**
		 * 获得空间的信息
		 *
		 * @param STRING $where
		 * @return unknown
		 */
		 function get_space($userid)
		{
			$userid = intval($userid);
			$spaceinfo = $this->db->get_one("SELECT * FROM $this->table WHERE userid=$userid");
			return $spaceinfo;
		}

		/**
		 * 激活个人空间
		 *
		 * @param INT $userid
		 * @return $spaceid
		 */
		function activate($userid)
		{
			$userid = intval($userid);
			if ($userid < 1) return false;
			if (!is_array($this->api) || empty($this->api)) return false;
			foreach ($this->api as $key=>$value)
			{
				if(!$value['disable']) $block_id .= $key.',';
			}
			if(empty($block_id))
			{
				$this->msg = 'admin_not_set_api';
				return false;
			}
			if($this->db->get_one("SELECT userid FROM `$this->table` WHERE userid='$userid'"))
			{
				$this->msg = 'have_actived';
				return false;
			}
			$this->db->update($this->table, array('userid'=>$userid, 'blockid'=>$block_id));
			$this->blockids = $block_id;
			return true;
		}
		
		function exists($userid)
		{
			$userid = intval($userid);
			if($userid < 1) return false;
			return $this->db->get_one("SELECT userid FROM $this->table WHERE userid='$userid'") ? true : false;
		}

		function block_pannel($userid)
		{
			$userid = intval($userid);
			$spaceinfo = $this->db->get_one("SELECT * FROM $this->table WHERE userid=$userid");
			$arr_block = explode(',', $spaceinfo['blockid']);
			foreach ($this->api as $k=>$v)
			{
				$v['installed'] = in_array($k, $arr_block) ? 1: 0;
				$block[] = $v;
			}
			return $block;
		}
		
		/**
		 * 修改用户的block
		 *
		 * @param INT $userid
		 * @param INT $spaceid
		 * @param ARRAY $blockid
		 */
		function edit_block($userid, $blockid)
		{
			$userid = intval($userid);
			$blockid = intval($blockid);
			if ($userid < 1 || $blockid < 1)
			{
				return false;
			}
			$ex_blockid = $this->db->get_one("SELECT blockid FROM $this->table WHERE userid='$userid'");
			$block = $ex_blockid['blockid'].$blockid;
			$array = array_unique(explode(',', $block));
			$array = implode(',', $array);
			$array = $array.',';
			$arr_update = array('blockid'=>$array);
			return $this->db->update($this->table, $arr_update, "userid='$userid'");
		}
		
		function del_block($userid, $blockid)
		{
			$userid = intval($userid);
			$blockid = intval($blockid);
			if ($userid < 1 || $blockid < 1)
			{
				return false;
			}
			$ex_blockid = $this->db->get_one("SELECT blockid FROM $this->table WHERE userid='$userid'");
			$arr_block = explode(',', $ex_blockid['blockid']);
			foreach ($arr_block as $k=>$v) 
			{
				if($blockid != $v)
				{
					$array .= $v.',';
				}
			}
			$array = substr($array, 0, -1);
			$block = array('blockid'=>$array);
			return $this->db->update($this->table, $block, "userid='$userid'");
		}
		
		/**
		 * 修改用户信息
		 *
		 * @param ARRAY $spaceinfo
		 * @return true
		 */
		function edit($userid, $spaceinfo)
		{
			$userid = intval($userid);
			if ($userid < 1)
			{
				$this->msg = '';
				return false;
			}
			if (!is_array($spaceinfo))
			{
				$this->msg = '';
				return false;
			}
			$this->db->update($this->table, $spaceinfo, " `userid`='$userid'");
			return true;
		}
		
		/**
		 * 对API信息进行缓存
		 *
		 * @param null
		 * @return 缓存信息
		 **/
		function cache()
		{
			cache_table(DB_PRE.'space_api', '*', '', 'disable=0', 'listorder', 0);
			return true; 
		}

		function msg()
		{
			global $LANG;
			return $LANG[$this->msg()];
		}

		function get_collect($page)
		{
			global $_userid;
			$page = max($page, 1);
			$pagesize = 20;
			$num = $this->db->get_one("SELECT COUNT(*) AS n FROM ".DB_PRE."collect cc, ".DB_PRE."content c WHERE c.`contentid`=cc.`contentid` AND cc.`userid`='$_userid' AND `status`=99");
			$total = $num['n'];
			$data['pages'] = pages($total, $page, $pagesize);
			$offset = ($page-1)*$pagesize;
			$data['collect'] = $this->db->select("SELECT c.contentid, id, c.title, c.catid, url, cc.addtime FROM .".DB_PRE."content c, ".DB_PRE."collect cc WHERE c.`contentid`=cc.`contentid` AND cc.`userid`='$_userid' AND `status`=99 ORDER BY id DESC LIMIT $offset, $pagesize");
			return $data;
		}
	}
?>