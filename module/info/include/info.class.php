<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class info
{
	var $channelid;
	var $infoid;
	var $db;
	var $table_info;

	function info($channelid)
    {
		global $db;
		$this->channelid = $channelid;
		$this->infoid = 0;
		$this->db = &$db;
		$this->table_info = channel_table('info', $channelid);
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
		unset($this->channelid);
		unset($this->infoid);
		unset($this->db);
		unset($this->table_info);
	}
	function add($info)
	{
		$sql1 = $sql2 = $s = "";
		foreach($info as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ",";
		}
		$this->db->query("INSERT INTO ".$this->table_info." ($sql1) VALUES($sql2) ");
		if(!$this->db->affected_rows()) return FALSE;
		$infoid = $this->db->insert_id();
		if(!$info['islink'])
		{
			global $CHA;
			$linkurl = item_url('url', $info['catid'], $info['ishtml'], $info['urlruleid'], $info['htmldir'], $info['prefix'], $infoid, $info['addtime']);
			$this->db->query("UPDATE ".$this->table_info." SET linkurl='$linkurl' WHERE infoid=$infoid ");
		}
		return $infoid;
	}

	function edit($info)
	{
		$infoid = $this->infoid;
		if(!$info['islink'])
		{
			global $CHA;
			$info['linkurl'] = item_url('url', $info['catid'], $info['ishtml'], $info['urlruleid'], $info['htmldir'], $info['prefix'], $infoid, $info['addtime']);
		}
		$sql = $s = "";
		foreach($info as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$this->db->query("UPDATE ".$this->table_info." SET $sql WHERE infoid=$infoid ");
		return TRUE;
	}

	function delete($infoids, $file = 0)//File为1时仅删除文件 编辑时有用
	{
		global $pos;
		$infoids = is_array($infoids) ? implode(',',$infoids) : $infoids;
		$sql = $infoids ? "infoid IN($infoids)" : "status=-1";//当infoids为空时，表示清空回收站
		if(!$file) require PHPCMS_ROOT.'/include/attachment.class.php';
		$result = $this->db->query("SELECT infoid,linkurl,thumb,catid,ishtml,urlruleid,htmldir,prefix,addtime FROM ".$this->table_info." WHERE $sql ");
		while($r = $this->db->fetch_array($result))
		{
			if(!$file && $r['arrposid']) $pos->delete($r['articleid'], $r['arrposid']);
			if($r['thumb'] && !preg_match("/http:\/\//",$r['thumb']) && !$file) @unlink(PHPCMS_ROOT.'/'.$r['thumb']);
			if(!$file)
			{
				$att = new attachment($r['infoid'], $this->channelid, $r['catid']);
				$att->delete();
			}
			if($r['ishtml'])
			{
				$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['infoid'], $r['addtime']);
				@unlink(PHPCMS_ROOT.'/'.$linkurl);
			}
		}
		if(!$file) $this->db->query("DELETE FROM ".$this->table_info." WHERE $sql ");
		return TRUE;
		
	}
	
	function get_list($sql = 'status=3 ', $order = 'listorder DESC')
	{
		global $offset, $pagesize, $CHA;
		if(empty($sql)) return FALSE;
		$offset = !empty($offset) ? intval($offset) : 0;
		$pagesize = !empty($pagesize) ? intval($pagesize) : 30;
		$TYPE = cache_read('type_'.$this->channelid.'.php');
		$result = $this->db->query("SELECT * FROM ".$this->table_info." WHERE $sql ORDER BY $order, infoid DESC LIMIT $offset,$pagesize");
		$infos = array();
		while($r = $this->db->fetch_array($result))
		{
			$r['title'] = style($r['title'], $r['style']);
			$r['typename'] = $r['typeid'] && array_key_exists($r['typeid'], $TYPE) ? style($TYPE[$r['typeid']]['name'], $TYPE[$r['typeid']]['style']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['adddate'] = date("Y-m-d",$r['addtime']);
			$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
			$r['checktime'] = date("Y-m-d H:i:s",$r['checktime']);
			$r['edittime'] = date("Y-m-d H:i:s",$r['edittime']);
			$infos[] = $r;
		}
		$this->db->free_result($result);
		$infos = !empty($infos) ? $infos : array();
		return $infos;
	}

	function get_one()
	{
		$r = $this->db->get_one("SELECT * FROM ".$this->table_info." WHERE infoid=$this->infoid ");
		return $r;
	}

	function action($job = 'status', $value = 3, $infoids)
	{
		if(empty($infoids)) return FALSE;
		if(is_array($infoids))
		{
			$html_infoids = $infoids;
			$infoids = implode(',', $infoids);
		}
		else
		{
			$html_infoids = array($infoids);
		}
		$this->db->query("UPDATE ".$this->table_info." SET $job=$value WHERE infoid IN ($infoids) ");
		if($job == 'status' && $value == 3)
		{
			global $_username,$PHP_TIME,$MOD,$MODULE;
			$this->db->query("UPDATE ".$this->table_info." SET checker='$_username', checktime=$PHP_TIME WHERE infoid IN ($infoids) ");
			if(isset($MODULE['pay']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$result = $this->db->query("select infoid,title,username,catid from ".$this->table_info." WHERE infoid IN ($infoids) ");
				while($r = $this->db->fetch_array($result))
				{
					if(!$r['username']) continue;
					$CAT = cache_read('category_'.$r['catid'].'.php');
					$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
					if($point) point_add($r['username'], $point, $r['title'].'(channelid='.$this->channelid.',infoid='.$r['infoid'].')');
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
			$this->db->query("UPDATE ".$this->table_info." SET listorder=$value WHERE infoid=$id ");
		}
		return TRUE;
	}

	function update()
	{
		global $CATEGORY;
		foreach($CATEGORY as $k=>$v)
		{
			$r = $this->db->get_one("SELECT COUNT(*) AS number FROM ".$this->table_info." WHERE catid=$k AND status=3 ");
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