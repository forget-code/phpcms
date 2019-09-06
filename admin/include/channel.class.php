<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class channel
{
	var $channelid = 0;
	var $channel;
	var $updatecache = 1;

    function channel($channelid = 0)
    {
        $this->channelid = $channelid;
        $this->channel = array();
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
		if($this->updatecache) cache_common();
		if($this->channelid) cache_channel($this->channelid);
	}

	function add($channel)
	{
		global $db;
		if(!is_array($channel)) return FALSE;
		$channel['linkurl'] = $channel['islink'] ? $channel['linkurl'] : ($channel['channeldomain'] ? $channel['channeldomain'] : $channel['channeldir']."/");
		$tmp = $db->get_one("select purview_message,point_message from ".TABLE_CHANNEL." where module='$channel[module]'");
		if($tmp)
		{
			$channel['purview_message'] = addslashes($tmp['purview_message']);
			$channel['point_message'] = addslashes($tmp['point_message']);
		}
		$sql1 = $sql2 = $s = "";
		foreach($channel as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ",";
		}
		$db->query("INSERT INTO ".TABLE_CHANNEL." ($sql1) VALUES($sql2)");
		if(!$db->affected_rows()) return FALSE;
		$channelid = $db->insert_id();
        $this->channelid = $channelid;
		$this->channel = $channel;
		$db->query("UPDATE ".TABLE_CHANNEL." SET listorder=$channelid WHERE channelid=$channelid");
		if(!$channel['islink'])
		{
			$this->create_table();
			$this->create_dir();
		}
		return $channelid;
	}

	function edit($channel)
	{
		global $db;
		if(!is_array($channel)) return FALSE;
		$channel['linkurl'] = $channel['islink'] ? $channel['linkurl'] : ($channel['channeldomain'] ? $channel['channeldomain'] : $channel['channeldir']).'/';
        $this->channel = $channel;
		$sql = $s = "";
		foreach($channel as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$db->query("UPDATE ".TABLE_CHANNEL." SET $sql WHERE channelid=$this->channelid");
		$this->updatecache = 1;
        return $db->affected_rows();
	}

	function delete()
	{
		global $db;
		if(!$this->channel) $this->channel = cache_read('channel_'.$this->channelid.'.php');
		$db->query("DELETE FROM ".TABLE_CHANNEL." WHERE channelid=$this->channelid");
		if(!$this->channel['islink'])
		{
            $this->drop_table();
			$CATEGORY = cache_read('categorys_'.$this->channelid.'.php');
			if(is_array($CATEGORY))
			{
				$catids = array();
				foreach($CATEGORY as $catid=>$cat)
				{
			        cache_delete('category_'.$catid.'.php');
					$catids[] = $catid;
				}
				$catids = implode(',', $catids);
				if($catids) $db->query("DELETE FROM ".TABLE_CATEGORY." WHERE catid IN($catids)");
			}
		    $db->query("DELETE FROM ".TABLE_SPECIAL." WHERE keyid='$this->channelid'");
			if(defined('TABLE_COMMENT')) $db->query("DELETE FROM ".TABLE_COMMENT." WHERE keyid='$this->channelid'");
	        $this->delete_dir();
			cache_delete('channel_'.$this->channelid.'.php');
			cache_delete('categorys_'.$this->channelid.'.php');
		}
        $this->channelid = 0;
		return TRUE;
	}

	function disable($value)
	{
		global $db;
		$db->query("UPDATE ".TABLE_CHANNEL." SET disabled='$value' WHERE channelid=$this->channelid");
        return $db->affected_rows();
	}

	function get_list()
	{
		global $db;
		$channels = array();
		$result = $db->query("SELECT channelid FROM ".TABLE_CHANNEL." ORDER BY listorder");
		while($r = $db->fetch_array($result))
		{
			$channels[] = $this->get_info($r['channelid']);
		}
		$db->free_result($result);
		$this->updatecache = 0;
		return $channels;
	}

	function get_info($channelid = 0)
	{
		global $db;
		if($channelid) $this->channelid = $channelid;
		$data = $db->get_one("SELECT * FROM ".TABLE_CHANNEL." WHERE channelid=$this->channelid");
		if($data['setting'])
		{
			$setting = unserialize($data['setting']);
			unset($data['setting']);
			$data = is_array($setting) ? array_merge($data, $setting) : $data;
		}
		$this->updatecache = 0;
		return $data;
	}

	function setting($setting)
	{
		global $db;
		if(!is_array($setting)) return FALSE;
		$setting = addslashes(serialize(new_stripslashes($setting)));
		$db->query("UPDATE ".TABLE_CHANNEL." SET setting='$setting' WHERE channelid=$this->channelid");
		return TRUE;
	}


	function listorder($listorder)
	{
		global $db;
		if(!is_array($listorder)) return FALSE;
		foreach($listorder as $channelid=>$value)
		{
			$value = intval($value);
			$db->query("UPDATE ".TABLE_CHANNEL." SET listorder=$value WHERE channelid=$channelid");
		}
		cache_channel();
		return TRUE;
	}

	function create_dir()
	{
		if(!$this->channel) $this->channel = cache_read('channel_'.$this->channelid.'.php');
		$channeldir = PHPCMS_ROOT.'/'.$this->channel['channeldir'].'/';
		dir_create($channeldir);
		dir_create($channeldir.$this->channel['uploaddir'].'/');
		dir_create($channeldir.'/thumb/');
		dir_copy(PHPCMS_ROOT.'/module/'.$this->channel['module'].'/copy/', $channeldir);
		$phpfiles = glob($channeldir.'*.php');
		$phpfiles1 = glob($channeldir.'special/*.php');
        if($phpfiles1) $phpfiles = array_merge($phpfiles, $phpfiles1);
		foreach($phpfiles as $phpfile)
		{
			@chmod($phpfile, 0755);
		}
		$config = "<?php\n\$mod = '".$this->channel['module']."';\n\$channelid = ".$this->channelid.";\n?>";
		file_put_contents($channeldir.'config.inc.php', $config);
		@chmod($channeldir.'config.inc.php', 0777);
	}

	function delete_dir()
	{
		if(!$this->channel) $this->channel = cache_read('channel_'.$this->channelid.'.php');
		@set_time_limit(600);
		if(!$this->channel['channeldir']) return FALSE;
		dir_delete(PHPCMS_ROOT.'/'.$this->channel['channeldir'].'/');
		return TRUE;
	}
    
	function create_table()
	{
		global $db,$CONFIG;
		if(!$this->channel) $this->channel = cache_read('channel_'.$this->channelid.'.php');
		$sqlfiles = glob(PHPCMS_ROOT.'/module/'.$this->channel['module'].'/include/'.$CONFIG['database'].'/*.sql');
		foreach($sqlfiles as $sqlfile)
		{
			$tablename = str_replace('.sql', '', basename($sqlfile));
			$newtablename = $tablename.'_'.$this->channelid;
			$sql = file_get_contents($sqlfile);
			$sql = str_replace($tablename, $newtablename, $sql);
			sql_execute($sql);
		}
		cache_table();
		return TRUE;
	}

	function drop_table()
	{
		global $db,$CONFIG;
		if(!$this->channel) $this->channel = cache_read('channel_'.$this->channelid.'.php');
		$sqlfiles = glob(PHPCMS_ROOT.'/module/'.$this->channel['module'].'/include/'.$CONFIG['database'].'/*.sql');
		foreach($sqlfiles as $sqlfile)
		{
			$tablename = str_replace('.sql', '', basename($sqlfile));
			$tablename = str_replace('phpcms_', '', $tablename);
			$tablename = channel_table($tablename, $this->channelid);
		    $db->query("DROP TABLE $tablename");
		}
		cache_table();
		return TRUE;
	}
}
?>