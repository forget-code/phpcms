<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class down
{
	var $channelid;
	var $downid;
	var $db;
	var $table_down;
	function down($channelid)
    {
		global $db;
		$this->channelid = $channelid;
		$this->downid = 0;
		$this->db = &$db;
		$this->table_down = channel_table('down', $channelid);
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
		unset($this->channelid);
		unset($this->downid);
		unset($this->db);
		unset($this->table_down);
	}
	function add($down)
	{
		$sql1 = $sql2 = $s = "";
		foreach($down as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ",";
		}
		$this->db->query("INSERT INTO ".$this->table_down." ($sql1) VALUES($sql2) ");
		if(!$this->db->affected_rows()) return FALSE;
		$downid = $this->db->insert_id();
		if(!$down['islink'])
		{
			$linkurl = item_url('url', $down['catid'], $down['ishtml'], $down['urlruleid'], $down['htmldir'], $down['prefix'], $downid, $down['addtime']);
			$this->db->query("UPDATE ".$this->table_down." SET linkurl='$linkurl' WHERE downid=$downid ");
		}
		return $downid;
	}

	function edit($down)
	{
		$downid = $this->downid;
		if(!$down['islink'])
		{
			$down['linkurl'] = item_url('url', $down['catid'], $down['ishtml'], $down['urlruleid'], $down['htmldir'], $down['prefix'], $downid, $down['addtime']);
		}
		$sql = $s = "";
		foreach($down as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$this->db->query("UPDATE ".$this->table_down." SET $sql WHERE downid=$downid ");
		return TRUE;
	}

	function delete($downids, $file = 0)//File为1时仅删除文件 编辑时有用
	{
		global $pos,$MOD;

		$downids = is_array($downids) ? implode(',',$downids) : $downids;
		$sql = $downids ? "downid IN($downids)" : "status=-1";//当downids为空时，表示清空回收站
		if(!$file) require PHPCMS_ROOT.'/include/attachment.class.php';
		$result = $this->db->query("SELECT downid,linkurl,thumb,username,catid,ishtml,urlruleid,htmldir,prefix,addtime FROM ".$this->table_down." WHERE $sql ");
		while($r = $this->db->fetch_array($result))
		{
			if(!$file && $r['arrposid']) $pos->delete($r['downid'], $r['arrposid']);
			if($r['thumb'] && !strpos($r['thumb'], "://") && !$file) @unlink(PHPCMS_ROOT.'/'.$r['thumb']);
			if($r['ishtml'])
			{
				$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['downid'], $r['addtime']);
				@unlink(PHPCMS_ROOT.'/'.$linkurl);
			}
			if(!$file)
			{
				$att = new attachment($r['downid'], $this->channelid, $r['catid']);
				$att->delete();
			}
		}
		if(!$file) $this->db->query("DELETE FROM ".$this->table_down." WHERE $sql ");
		return TRUE;
		
	}
	
	function get_list($sql = 'status=3 ', $order = 'listorder DESC')
	{
		global $offset, $pagesize;
		if(empty($sql)) return FALSE;
		$offset = !empty($offset) ? intval($offset) : 0;
		$pagesize = !empty($pagesize) ? intval($pagesize) : 30;
		$TYPE = cache_read('type_'.$this->channelid.'.php');
		$result = $this->db->query("SELECT * FROM ".$this->table_down." WHERE $sql ORDER BY $order, downid DESC LIMIT $offset,$pagesize");
		$downs = array();
		while($r = $this->db->fetch_array($result))
		{
			$r['title'] = style($r['title'], $r['style']);
			$r['typename'] = $r['typeid'] && array_key_exists($r['typeid'], $TYPE) ? style($TYPE[$r['typeid']]['name'], $TYPE[$r['typeid']]['style']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['adddate'] = date("Y-m-d",$r['addtime']);
			$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
			$r['checktime'] = date("Y-m-d H:i:s",$r['checktime']);
			$r['edittime'] = date("Y-m-d H:i:s",$r['edittime']);
			$downs[] = $r;
		}
		$this->db->free_result($result);
		$downs = !empty($downs) ? $downs : array();
		return $downs;
	}

	function get_one()
	{
		$r = $this->db->get_one("SELECT * FROM ".$this->table_down." WHERE downid=$this->downid ");
		return $r;
	}

	function action($job = 'status', $value = 3, $downids)
	{
		if(empty($downids)) return FALSE;
		if(is_array($downids))
		{
			$html_downids = $downids;
			$downids = implode(',', $downids);
		}
		else
		{
			$html_downids = array($downids);
		}
		$this->db->query("UPDATE ".$this->table_down." SET $job=$value WHERE downid IN ($downids) ");
		if($job == 'status' && $value == 3)
		{
			global $_username,$PHP_TIME,$MOD,$MODULE;
			$this->db->query("UPDATE ".$this->table_down." SET checker='$_username', checktime=$PHP_TIME WHERE downid IN ($downids) ");
			if(isset($MODULE['pay']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$result = $this->db->query("select downid,title,username,catid from ".$this->table_down." WHERE downid IN ($downids) ");
				while($r = $this->db->fetch_array($result))
				{
					if(!$r['username']) continue;
					$CAT = cache_read('category_'.$r['catid'].'.php');
					$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
					if($point) point_add($r['username'], $point, $r['title'].'(channelid='.$this->channelid.',downid='.$r['downid'].')');
				}
			}
		}
		return TRUE;
	}

	function listorder($listorder)
	{
		if(!is_array($listorder)) return FALSE;
		foreach($listorder as $id=>$value)
		{
			$this->db->query("UPDATE ".$this->table_down." SET listorder=$value WHERE downid=$id ");
		}
		return TRUE;
	}

	function update()
	{
		global $CATEGORY;
		foreach($CATEGORY as $k=>$v)
		{
			$r = $this->db->get_one("SELECT COUNT(*) AS number FROM ".$this->table_down." WHERE catid=$k AND status=3 ");
			$this->db->query("UPDATE ".TABLE_CATEGORY." SET items={$r['number']} WHERE catid=$k AND channelid=$this->channelid ");
			cache_category($k);
		}
		$items = 0;
		foreach($CATEGORY as $k=>$v)
		{
			$cat = cache_read("category_$k.php");
			$items+=$cat['items'];
		}
		$this->db->query("UPDATE ".TABLE_CHANNEL." SET items=$items WHERE channelid=$this->channelid ");
		cache_channel($this->channelid);
		return TRUE;
	}
}
?>