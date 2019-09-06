<?php 
if (!class_exists('space'))
{
	require MOD_ROOT.'include/space.class.php';
}

class space_admin extends space 
{
	function list_api($where, $order = '', $page = 1, $pagesize = 100)
	{
		$api_result = $this->_listinfo_api($where, $order = 'apiid ASC', $page, $pagesize);
		return $api_result;
	}
	
	/**
	 * 添加API
	 *
	 * @param ARRAY $info
	 * @return $apiid
	 */
	function add_api($info)
	{
		if(!$this->_api_check($info)) 
		{
			return false;
		}
		extract($info);
		$arr_api = array('module'=>$module, 'name'=>$name, 'url'=>$url, 'template'=>$template);
		$apiid = $this->db->insert($this->api_table, $arr_api);
		$this->cache();
		return $apiid;
	}
	
	/**
	 * 修改用户API信息
	 *
	 * @param ARRAY $info
	 * @return unknown
	 */
	function edit_api($info)
	{
		if(!$this->_api_check($info)) return false;
		extract($info);
		$arr_api = array('apiid'=>$apiid, 'module'=>$module, 'name'=>$name, 'url'=>$url);
		$this->db->update($this->api_table, $arr_api);
		return $this->cache();
	}


	/**
	 * 对API顺序进行排序
	 *
	 * @param ARRAY $info
	 * @return true
	 */
	function listorder($info)
	{
		if(!is_array($info) || empty($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$id = intval($id);
			$listorder = intval($listorder);
			$this->db->query("UPDATE `$this->api_table` SET `listorder`=$listorder WHERE `apiid`='$id'");	
		}
		return $this->cache();
	}
	
	/**
	 * 删除空间api
	 *
	 * @param INT $apiid
	 * @return unknown
	 */
	function delete_api($apiid)
	{
		if(is_array($apiid))
		{
			$apiid = array_map("intval", $apiid);
			$apiid = implode(',', $apiid);
		}
		else
		{
			$apiid = intval($apiid);
		}
		$this->db->query("DELETE FROM $this->api_table WHERE apiid IN ($apiid)");
		return $this->cache();
	}	
	
	function disable($apiid, $val)
	{
		$apiid = intval($apiid);
		if($apiid < 1) return false;
		$val = intval($val) ? 1: 0;
		$arr_disable = array('disable'=>$val);
		$this->db->update($this->api_table, $arr_disable, "apiid='$apiid'"); 
		return $this->cache();
	}
	
	/**
	 * API检查
	 *
	 * @param ARRAY $info
	 * @return $info
	 */
	function _api_check($info)
	{
		if(!is_array($info))
		{
			$this->msg = 'valide input';
			return false;
		}
		if (!$info['name'])
		{
			$this->msg = 'apiname_is_null';
			return false;
		}
		elseif (!$info['module'])
		{
			$this->msg = 'apimodule_is_null';
			return false;
		}
		elseif (!$info['url'])
		{
			$this->msg = 'apiurl_is_null';
			return false;
		}
		return true;
	}
}
?>