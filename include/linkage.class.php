<?php
/**
 * linkage class file
 *
 * @author				phpip(wangcanjia@phpip.com)
 * @link				http://www.phpcms.cn
 * @copyright			2005-2010 PHPCMS Software LLCS
 * @license				http://www.phpcms.cn/license/
 * @datetime			2010-3-25
 * @lastmodify			2010-3-25
 * 
 */
class linkage
{
	var $db;
	var $table;

	function linkage()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'linkage';
	}

	function get($linkageid, $fields = '*')
	{
		$linkageid = intval($linkageid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `linkageid`=$linkageid");
	}

	function add($data)
	{
		if(!is_array($data)) return FALSE;
        $this->db->insert($this->table, $data);
		$id = $this->db->insert_id();
		$this->cache($data['keyid']);
		return $id;
	}

	function edit($linkageid, $info)
	{
		$this->db->update($this->table, $info, "linkageid=$linkageid");
		$id = $info['keyid'] ? $info['keyid'] : $linkageid;
		$this->cache($id);
		return TRUE;
	}

	function delete($linkageid,$keyid = 0)
	{
		$this->db->query("DELETE FROM $this->table WHERE parentid = '$linkageid'");
		$this->db->query("DELETE FROM $this->table WHERE linkageid = '$linkageid'");
		$this->db->query("DELETE FROM $this->table WHERE keyid = '$linkageid'");
		if($keyid) $this->cache($keyid);
		return TRUE;
	}

	function listorder($listorder)
	{
	    if(!is_array($listorder)) return FALSE;
		foreach($listorder as $linkageid=>$value)
		{
			$value = intval($value);
			$this->db->query("UPDATE ".$this->table." SET listorder=$value WHERE linkageid=$linkageid");
		}
		return TRUE;
	}

	function listinfo()
	{
		$datas = array();
		
		$result = $this->db->query("SELECT * FROM $this->table WHERE keyid=0 ORDER BY `linkageid`");
		while($r = $this->db->fetch_array($result))
		{
			$datas[] = $r;
		}
		$this->db->free_result($result);
		return $datas;
	}
	function submenulist($keyid=0)
	{
		$keyid = intval($keyid);
		$datas = array();
		$result = $this->db->query("SELECT * FROM $this->table WHERE keyid='$keyid' ORDER BY `listorder`,`linkageid`");
		while($r = $this->db->fetch_array($result))
		{
			$datas[$r['linkageid']] = $r;
		}
		$this->db->free_result($result);
		return $datas;
	}
	function repair()
	{
		@set_time_limit(600);
		if(is_array($this->linkages))
		{
			foreach($this->linkages as $linkageid => $area)
			{
				$arrparentid = $this->get_arrparentid($linkageid);
				$arrchildid = $this->get_arrchildid($linkageid);
				$child = is_numeric($arrchildid) ? 0 : 1;
		        $this->db->query("UPDATE `$this->table` SET `arrparentid`='$arrparentid',`arrchildid`='$arrchildid',`child`='$child' WHERE `linkageid`=$linkageid");
			}
		}
        return TRUE;
	}

	function get_arrparentid($linkageid, $arrparentid = '', $n = 1)
	{
		if($n > 6 || !is_array($this->linkages) || !isset($this->linkages[$linkageid])) return false;
		$parentid = $this->linkages[$linkageid]['parentid'];
		$arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		if($parentid)
		{
			$arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
		}
		else
		{
			$this->linkages[$linkageid]['arrparentid'] = $arrparentid;
		}
		return $arrparentid;
	}

	function get_arrchildid($linkageid)
	{
		$arrchildid = $linkageid;
		if(is_array($this->linkages))
		{
			foreach($this->linkages as $id => $area)
			{
				if($area['parentid'] && $id != $linkageid)
				{
					$arrparentids = explode(',', $area['arrparentid']);
					if(in_array($linkageid, $arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}

	function cache($linkageid)
	{
		$r = $this->get($linkageid,'name');
		$info['title'] = $r['name'];
		$info['data'] = $this->submenulist($linkageid);
		cache_write($linkageid.'.php',$info,PHPCMS_ROOT.'data/linkage/');
	}
}
?>