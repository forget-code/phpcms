<?php
class menu
{
	var $db;
	var $pages;
	var $number;
	var $table;

    function __construct()
    {
		global $db, $_userid;
		$this->db = &$db;
		$this->table = DB_PRE.'menu';
		$this->userid = $_userid;
    }

	function menu()
	{
		$this->__construct();
	}

	function get($menuid, $fields = '*')
	{
		$menuid = intval($menuid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `menuid`=$menuid");
	}

	function add($menu)
	{
		if(!is_array($menu) || empty($menu['name'])) return false;
		$menu['userid'] = $menu['parentid'] == 99 ? $this->userid : 0;
		$this->db->insert($this->table, $menu);
		$menuid = $this->db->insert_id();
		if($menu['parentid'])
		{
			$parentid = $menu['parentid'];
			$this->db->query("UPDATE `$this->table` SET `isfolder`=1 WHERE `menuid`=$parentid");
		}
		return $menuid;
	}

	function edit($menuid, $menu)
	{
		if(!$menuid || !is_array($menu)) return false;
		$menu['userid'] = $menu['parentid'] == 10 ? $this->userid : 0;
		$r = $this->get($menuid, 'parentid');
		if(!$r) return false;
		if($r['parentid'] != $menu['parentid'])
		{
			if($r['parentid']) $this->update_isfolder($r['parentid']);
			if($menu['parentid'])
			{
				$parentid = $menu['parentid'];
				$this->db->query("UPDATE `$this->table` SET `isfolder`=1 WHERE `menuid`=$parentid");
			}
		}
		return $this->db->update($this->table, $menu, "menuid=$menuid");
	}

	function delete($menuid, $isonlychild = 0)
	{
		$menuid = intval($menuid);
		$r = $this->get($menuid, 'parentid');
		if(!$r) return false;
		$menuids = $this->get_child_menuid($menuid);
		if($isonlychild == 0) $menuids[] = $menuid;
		$menuids = implode(',', $menuids);
		$this->db->query("DELETE FROM `$this->table` WHERE `menuid` IN($menuids)");
		if($r['parentid']) $this->update_isfolder($r['parentid']);
		return true;
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as number FROM $this->table $where");
        $number = $r['number'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
		$this->number = $this->db->num_rows($result);
        $this->db->free_result($result);
		return $array;
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE `$this->table` SET `listorder`=$listorder WHERE `menuid`=$id");
		}
		return true;
	}

	function disable($menuid, $disabled)
	{
		$menuid = intval($menuid);
		if($menuid < 1) return false;
		return $this->db->query("UPDATE `$this->table` SET `disabled`=$disabled WHERE `menuid`=$menuid");
	}

	function update($keyid, $data = array())
	{
		$menuid = $this->menuid($keyid);
		if($data)
		{
			if($menuid)
            {
                $this->edit($menuid, $data);
            }
			else
			{
				$data['keyid'] = $keyid;
				$this->add($data);
			}
		}
		elseif($menuid)
		{
			$this->delete($menuid);
		}
		return true;
	}

	function menuid($keyid)
	{
		$r = $this->db->get_one("SELECT `menuid` FROM `$this->table` WHERE `keyid`='$keyid' LIMIT 1");
		return $r ? $r['menuid'] : false;
	}

	function get_child_menuid($menuid, $menuids = array())
	{
		$menuid = intval($menuid);
		$result = $this->db->query("SELECT `menuid`,`isfolder` FROM `$this->table` WHERE `parentid`=$menuid");
		while($r = $this->db->fetch_array($result))
		{
			$menuids[] = $r['menuid'];
            if($r['isfolder']) $menuids = $this->get_child_menuid($r['menuid'], $menuids);
		}
		$this->db->free_result($result);
		return $menuids;
	}

	function get_child($menuid = 0, $fields = '*')
	{
		global $_roleid;
		$menuid = intval($menuid);
		$data = $this->db->select("SELECT $fields FROM `$this->table` WHERE `parentid`=$menuid ORDER BY `listorder`, `menuid`");
		foreach($data as $k=>$r)
		{
			if($r['roleids'] && !check_in($_roleid, $r['roleids'])) unset($data[$k]);
		}
		return $data;
	}
	
	function get_childs($menuid = 0, $fields = '*')
	{
		global  $_roleid;
		$menuid = intval($menuid);
		$data = $this->db->select("SELECT $fields FROM `$this->table` WHERE `parentid`=$menuid ORDER BY `listorder`, `menuid`");
		foreach($data as $k=>$r)
		{
			if($r['roleids'] && !check_in($_roleid, $r['roleids'])) continue;
			$array[$k] = $r;
			if ($r['isfolder'] == 1) {
				$array[$k]['child'] = $this->get_childs($r['menuid'], $fields);
			}
		}
		return $array;
	}

	function get_parent($menuid, $menu = array(), $deep = 0)
	{
		$r = $this->db->get_one("SELECT `name`,`url`,`target`,`isfolder`,`menuid`,`parentid` FROM `$this->table` WHERE `menuid`='$menuid'");
		if($r['parentid'] && $deep < 10)
		{
			$menu[] = $r;
			$menu = $this->get_parent($r['parentid'], $menu, ++$deep);
		}
		return $menu;
	}

	function update_isfolder($menuid)
	{
		$menuid = intval($menuid);
		$isfolder = $this->db->get_one("SELECT `menuid` FROM `$this->table` WHERE `parentid`=$menuid LIMIT 1") ? 1 : 0;
		if(!$isfolder)
		{
			$r = $this->db->get_one("SELECT `keyid` FROM `$this->table` WHERE `menuid`=$menuid");
			$keyid = explode('_', $r['keyid']);
			if(trim($keyid[0])=='catid')
			{
				$url = '?mod=phpcms&file=content&action=manage&catid='.trim($keyid[1]);
			}
		}
		else
		{
			$url = '';
		}
		return $this->db->query("UPDATE `$this->table` SET `isfolder`=$isfolder, `url`='$url' WHERE `menuid`=$menuid");
	}
}
?>