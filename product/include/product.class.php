<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class product
{
	var $productid;
	var $db;

	function product()
    {
		global $db;
		$this->productid = 0;
		$this->db = $db;
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
		unset($this->productid);
		unset($this->db);
	}
	function add($product)
	{
		$sql1 = $sql2 = $s = "";
		foreach($article as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ",";
		}
		$this->db->query("INSERT INTO ".TABLE_PRODUCT." ($sql1) VALUES($sql2) ");
		if(!$this->db->affected_rows()) return FALSE;
		$productid = $this->db->insert_id();
		$this->productid = $productid;
		if(!$product['islink'])
		{
			$linkurl = item_url('url', $product['catid'], $product['ishtml'], $product['urlruleid'], $product['htmldir'], $product['prefix'], $productid, $product['addtime']);
			$this->db->query("UPDATE ".TABLE_PRODUCT." SET linkurl='$linkurl' WHERE productid=$productid");
		}
		if($product['ishtml'])
		{
			createhtml('product');
		}
		return $productid;
	}

	function edit($product)
	{
		$productid = $this->productid;
		if(!$product['islink'])
		{
			$product['linkurl'] = get_item_url('url', $product['catid'], $product['ishtml'], $product['urlruleid'], $product['htmldir'], $product['prefix'], $productid, $product['addtime']);
		}
		$sql = $s = "";
		foreach($product as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$this->db->query("UPDATE ".TABLE_PRODUCT." SET $sql WHERE productid=$productid ");
		if($product['ishtml'])
		{
			createhtml('product');
		}
		return TRUE;
	}

	function delete($productids,$html='')
	{
		$productids=is_array($productids) ? implode(',',$productids) : $productids;
		$sql = $productids ? "productid IN ($productids)" : "disabled = 1";
		$result = $this->db->query("SELECT productid,linkurl,pdt_img,ishtml FROM ".TABLE_PRODUCT." WHERE $sql ");
		while($r = $this->db->fetch_array($result))
		{
			if(empty($html) && $r['pdt_img'] && !preg_match("/http:\/\//",$r['pdt_img'])) @unlink(PHPCMS_ROOT.'/'.$r['pdt_img']);
			if($r['ishtml'] && file_exists(PHPCMS_ROOT.'/'.$r['linkurl']))
			{ 
				unlink(PHPCMS_ROOT.'/'.$r['linkurl']);
			}
		}
		if(empty($html)) $this->db->query("DELETE FROM ".TABLE_PRODUCT." WHERE $sql ");
	}
		
	function get_list($sql = 'disabled=0 ', $order = 'listorder DESC')
	{
		global $offset, $pagesize;
		if(empty($sql)) return FALSE;
		$offset = !empty($offset) ? intval($offset) : 0;
		$pagesize = !empty($pagesize) ? intval($pagesize) : 30;
		if($pagesize>500) $pagesize = 500;
		$products = array();
		$result = $this->db->query("SELECT * FROM ".TABLE_PRODUCT." WHERE $sql ORDER BY $order, productid DESC LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result))
		{
			$r['pdt_name'] = style($r['pdt_name'], $r['style']);
			$r['addtime'] = date("Y-m-d",$r['addtime']);
			$products[] = $r;
		}
		$this->db->free_result($result);
		return $products;
	}
	
	function get_one()
	{
		$r = $this->db->get_one("SELECT * FROM ".TABLE_PRODUCT." productid = $this->productid");
		return $r;
	}

	function action($job = 'disabled', $value = 0, $productids,$isrecycle=0)
	{
		if(empty($productids)) return FALSE;
		$productids = is_array($productids) ? implode(',',$productids) : $productids;
		
		if($isrecycle)
		{
			$this->delete($productids,'');
		}
		else 
		{
			$this->db->query("UPDATE ".TABLE_PRODUCT." SET $job=$value WHERE productid IN ($productids) ");
			if($job == 'disabled' && $value == 1)
			{
				$t = time();
				$this->db->query("UPDATE ".TABLE_PRODUCT." SET edittime=$t WHERE  productid IN ($productids) ");			
			}
		}
		return TRUE;
	}
	
	function listorder($listorder)
	{
		if(!is_array($listorder)) return FALSE;
		foreach($listorder as $id => $value)
		{
			$this->db->query("UPDATE ".TABLE_PRODUCT." SET listorder = $value WHERE productid=$id");
		}
		return TRUE;
	}
}
?>