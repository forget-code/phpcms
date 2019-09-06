<?php 
class position
{
	var $keyid;
	var $table;
	var $module;
    var $posdir;

	function position($keyid)
	{
		global $MODULE,$CHANNEL,$CONFIG;
		$this->keyid = $keyid;
		if(is_numeric($keyid))
		{
			$channelid = intval($keyid);
			$this->module = $CHANNEL[$channelid]['module'];
			$this->table = channel_table($this->module, $channelid);
			$this->posdir = PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/';
		}
		else
		{
			$this->module = $keyid;
			$this->table = $CONFIG['tablepre'].$keyid;
			$this->posdir = PHPCMS_ROOT.'/'.$MODULE[$keyid]['moduledir'].'/pos/';
		}
	}

	function add($itemid, $posid_arr)
	{
		if(!$posid_arr || !is_array($posid_arr)) return FALSE;
		foreach($posid_arr as $posid)
		{
			$this->_add($itemid, $posid);
		}
	}

	function edit($itemid, $old_posid_arr, $posid_arr)
	{
		if(!is_array($posid_arr) || !is_array($old_posid_arr)) return FALSE;
		$arr_add = array_diff($posid_arr, $old_posid_arr);
        if($arr_add) $this->add($itemid, $arr_add);
		$arr_del = array_diff($old_posid_arr, $posid_arr);
        if($arr_del) $this->delete($itemid, $arr_del);
	}

	function delete($itemid, $posid_arr)
	{
		if(!$posid_arr) return FALSE;
		if(!is_array($posid_arr)) $posid_arr = array_filter(explode(',', $posid_arr));
		foreach($posid_arr as $posid)
		{
			$this->_delete($itemid, $posid);
		}
	}

	function update($posid = 0)
	{
		global $db;
		if($posid)
		{
			$idfield = $this->module.'id';
			$itemids = '';
			$res = $db->query("SELECT $idfield FROM $this->table WHERE arrposid LIKE '%,$posid,%'");
			while($p = $db->fetch_array($res))
			{
				$itemids = ','.$p[$idfield];
			}
			if($itemids) $itemids = substr($itemids, 1);
			$file = $this->posdir.$posid.'.txt';
			file_put_contents($file, $itemids);
		}
		else
		{
			$posid_arr = $this->get_posid_arr();
			foreach($posid_arr as $posid=>$name)
			{
				$this->update($posid);
			}
		}
	}

	function checkbox($inputname = 'posid', $arrposid = '')
	{
		$checkbox = '';
		$i = 1;
		$posid_arr = $this->get_posid_arr();
		foreach($posid_arr as $posid=>$name)
		{
			$checkbox .= ' <input type="checkbox" name="'.$inputname.'" value="'.$posid.'" '.(strpos($arrposid, ','.$posid.',') === FALSE ? '' : 'checked').'> '.$name;
			if($i%5 == 0) $checkbox .= '<br />';
			$i++;
		}
		return $checkbox;
	}

	function get_posid_arr()
	{
		global $db;
		$posid_arr = array();
		$result = $db->query("SELECT posid,name FROM ".TABLE_POSITION." WHERE keyid='$this->keyid' OR keyid=''");
		while($r = $db->fetch_array($result))
		{
			$posid_arr[$r['posid']] = $r['name'];
		}
		return $posid_arr;
	}

	function _add($itemid, $posid)
	{
        $file = $this->posdir.$posid.'.txt';
		if(!file_exists($file) || filesize($file) == 0)
		{
			$data = $itemid;
		}
		else
		{
			$itemids = file_get_contents($file);
            $data = $itemid.','.(substr_count($itemids, ',') < 200 ? $itemids : preg_replace("/^([0-9,]+),[0-9]+$/", "\\1", $itemids));
		}
		return file_put_contents($file, $data);
	}

	function _delete($itemid, $posid)
	{
        $file = $this->posdir.$posid.'.txt';
		if(!file_exists($file) || filesize($file) == 0) return TRUE;
		$itemids = file_get_contents($file);
        $itemids = str_replace(','.$itemid.',', ',', ','.$itemids.',');
        $itemids = substr($itemids, 1, -1);
		return file_put_contents($file, $itemids);
	}
}
?>