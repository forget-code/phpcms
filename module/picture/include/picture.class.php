<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class picture
{
	var $channelid;
	var $pictureid;
	var $db;
	var $table_picture;

	function picture($channelid)
    {
		global $db;
		$this->channelid = $channelid;
		$this->pictureid = 0;
		$this->db = &$db;
		$this->table_picture = channel_table('picture', $channelid);
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
		unset($this->channelid);
		unset($this->pictureid);
		unset($this->db);
		unset($this->table_picture);
	}
	function add($picture)
	{
		$sql1 = $sql2 = $s = "";
		foreach($picture as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ",";
		}
		$this->db->query("INSERT INTO ".$this->table_picture." ($sql1) VALUES($sql2) ");
		if(!$this->db->affected_rows()) return FALSE;
		$pictureid = $this->db->insert_id();
		if(!$picture['islink'])
		{
			$linkurl = item_url('url', $picture['catid'], $picture['ishtml'], $picture['urlruleid'], $picture['htmldir'], $picture['prefix'], $pictureid, $picture['addtime']);
			$this->db->query("UPDATE ".$this->table_picture." SET linkurl='$linkurl' WHERE pictureid=$pictureid ");
		}
		return $pictureid;
	}

	function edit($picture)
	{
		$pictureid = $this->pictureid;
		if(!$picture['islink'])
		{
			$picture['linkurl'] = item_url('url', $picture['catid'], $picture['ishtml'], $picture['urlruleid'], $picture['htmldir'], $picture['prefix'], $pictureid, $picture['addtime']);
		}
		$sql = $s = "";
		foreach($picture as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$this->db->query("UPDATE ".$this->table_picture." SET $sql WHERE pictureid=$pictureid ");
		return TRUE;
	}

	function delete($pictureids, $file = 0)//File为1时仅删除文件 编辑时有用
	{
		global $pos,$MOD;
		$pictureids = is_array($pictureids) ? implode(',',$pictureids) : $pictureids;
		$sql = $pictureids ? "pictureid IN($pictureids)" : "status=-1";//当pictureids为空时，表示清空回收站
		if(!$file) require PHPCMS_ROOT.'/include/attachment.class.php';
		$result = $this->db->query("SELECT pictureid,pictureurls,linkurl,username,thumb,catid,ishtml,urlruleid,htmldir,prefix,addtime FROM ".$this->table_picture." WHERE $sql ");
		while($r = $this->db->fetch_array($result))
		{
			if(!$file && $r['arrposid']) $pos->delete($r['pictureid'], $r['arrposid']);
			if($r['thumb'] && !strpos($r['thumb'], "://") && !$file) @unlink(PHPCMS_ROOT.'/'.$r['thumb']);
			if(!$file)
			{
				$att = new attachment($r['pictureid'], $this->channelid, $r['catid']);
				$att->delete();
			}
			if($r['ishtml'])
			{
				$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['pictureid'], $r['addtime']);
				@unlink(PHPCMS_ROOT.'/'.$linkurl);//删除平铺页
				$urls = explode("\n", $r['pictureurls']);
				$urls = array_map("trim", $urls);
				foreach($urls as $k=>$url)//删除图片页
				{
					if($url == '') continue;
					$linkurl = linkurl(item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['pictureid'], $r['addtime'], $k+1));
					@unlink(PHPCMS_ROOT.'/'.$linkurl);
					if(!$file)//删除图片
					{
						$url = explode("|", $url);
						if($url[0] && !strpos($url[0], "://"))
						{
							$fileurl = PHPCMS_ROOT.'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.$url[1];
							@unlink($fileurl);
							@unlink(dirname($fileurl).'/thumb_'.basename($fileurl));
						}
					}
				}
			}
		}
		if(!$file) $this->db->query("DELETE FROM ".$this->table_picture." WHERE $sql ");
		return TRUE;
		
	}
	
	function get_list($sql = 'status=3 ', $order = 'listorder DESC')
	{
		global $offset, $pagesize;
		if(empty($sql)) return FALSE;
		$offset = !empty($offset) ? intval($offset) : 0;
		$pagesize = !empty($pagesize) ? intval($pagesize) : 30;
		$TYPE = cache_read('type_'.$this->channelid.'.php');
		$result = $this->db->query("SELECT * FROM ".$this->table_picture." WHERE $sql ORDER BY $order, pictureid DESC LIMIT $offset,$pagesize");
		$pictures = array();
		while($r = $this->db->fetch_array($result))
		{
			$r['title'] = style($r['title'], $r['style']);
			$r['typename'] = $r['typeid'] && array_key_exists($r['typeid'], $TYPE) ? style($TYPE[$r['typeid']]['name'], $TYPE[$r['typeid']]['style']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['adddate'] = date("Y-m-d",$r['addtime']);
			$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
			$r['checktime'] = date("Y-m-d H:i:s",$r['checktime']);
			$r['edittime'] = date("Y-m-d H:i:s",$r['edittime']);
			$pictures[] = $r;
		}
		$this->db->free_result($result);
		$pictures = !empty($pictures) ? $pictures : array();
		return $pictures;
	}

	function get_one()
	{
		$r = $this->db->get_one("SELECT * FROM ".$this->table_picture." WHERE pictureid=$this->pictureid ");
		return $r;
	}

	function action($job = 'status', $value = 3, $pictureids)
	{
		if(empty($pictureids)) return FALSE;
		if(is_array($pictureids))
		{
			$html_pictureids = $pictureids;
			$pictureids = implode(',', $pictureids);
		}
		else
		{
			$html_pictureids = array($pictureids);
		}
		$this->db->query("UPDATE ".$this->table_picture." SET $job=$value WHERE pictureid IN ($pictureids) ");
		if($job == 'status' && $value == 3)
		{
			global $_username,$PHP_TIME,$MOD,$MODULE,$CHA;
			$this->db->query("UPDATE ".$this->table_picture." SET checker='$_username', checktime=$PHP_TIME WHERE pictureid IN ($pictureids) ");
			if(isset($MODULE['pay']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$result = $this->db->query("select pictureid,title,username,catid from ".$this->table_picture." WHERE pictureid IN ($pictureids) ");
				while($r = $this->db->fetch_array($result))
				{
					if(!$r['username']) continue;
					$CAT = cache_read('category_'.$r['catid'].'.php');
					$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
					if($point) 	point_add($r['username'], $point, $r['title'].'(channelid='.$this->channelid.',pictureid='.$r['pictureid'].')');
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
			$this->db->query("UPDATE ".$this->table_picture." SET listorder=$value WHERE pictureid=$id ");
		}
		return TRUE;
	}

	function update()
	{
		global $CATEGORY;
		foreach($CATEGORY as $k=>$v)
		{
			$r = $this->db->get_one("SELECT COUNT(*) AS number FROM ".$this->table_picture." WHERE catid=$k AND status=3 ");
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