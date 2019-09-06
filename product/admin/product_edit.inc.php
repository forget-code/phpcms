<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($mod);

if(isset($submit))
{ 
	//检查浏览器输入
	if(empty($pdt['pdt_name']))
	{
		showmessage($LANG['product_name_not_null'],'goback');
	}
	if(!isset($productid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$productid = intval($productid);
	$pdt['catid'] = intval($pdt['catid']);
	if($pdt['catid'] == 0)
	{
		showmessage($LANG['select_product_category'],'goback');
	}
	if(empty($pdt['price']))
	{
		showmessage($LANG['product_price_not_null'],'goback');
	}
	if(numberval($pdt['price'])===false)
	{
		showmessage($LANG['product_price_format_error'],'goback');
	}
	//如果以前生成了该商品html,先删除
	if($ishtmled) 
	{
		$pdtcls->delete($productid,'html');
	}
	//检查brand表 得到插入或更新的brand_id
	$brandid = 0;
	if(!empty($pdt['pdt_brand']))
	{
		$checkbrandsql = "SELECT brand_id,brand_name FROM ".TABLE_PRODUCT_BRAND." WHERE brand_name ='".$pdt['pdt_brand']."'";
		$db->query($checkbrandsql);
		if($db->affected_rows()>0)
		{
			$r = $db->get_one($checkbrandsql);
			$brandid = $r['brand_id'];
		}
		else
		{
			$db->query("INSERT INTO ".TABLE_PRODUCT_BRAND."(brand_name) VALUES ('".$pdt['pdt_brand']."')");
			$brandid = $db->insert_id();
			cache_brands();
		}
	}
	//生成商品编号
	if(empty($pdt['pdt_No']))
	{
		$pdt['pdt_No']='PCSPDT'.$PHP_TIME;
	}
	//赋值处理
	$pdt['subtype'] = intval($pdt['subtype']);
	$pdt['pro_id'] = intval($propertyselect);
	$pdt['price'] = sprintf('%01.2f',$pdt['price']);
	$pdt['marketprice'] = sprintf('%01.2f',$pdt['marketprice']);
	$pdt['pdt_weight'] = sprintf('%01.3f',$pdt['pdt_weight']);
	$pdt['edittime'] = $PHP_TIME;
	$pdt['onsale'] = intval($pdt['onsale'])==1 ? 1 : 0;
	$pdt['brand_id'] = $brandid; 
	$pdt['urlruleid'] = $pdt['ishtml'] ? $html_urlrule : $php_urlrule;
	unset($pdt['pdt_brand']);
	//生成URl规则
	
	if(isset($pdt['arrposid']))
	{
		$arrposid = $pdt['arrposid'];
		$pdt['arrposid'] = ','.implode(',', $arrposid).',';
	}
	
	$pdt['linkurl'] = item_url('url', $pdt['catid'], $pdt['ishtml'], $pdt['urlruleid'], $pdt['htmldir'], $pdt['prefix'], $productid, $pdt['addtime']);
	if(strpos($pdt['pdt_img'],'http')===false)
	{
		$pdt['pdt_thumb'] = str_replace(basename($pdt['pdt_img']),'thumb_'.basename($pdt['pdt_img']),$pdt['pdt_img']);
	}
	//更新SQL
	$sql = $s = "";
	foreach($pdt as $key=>$value)
	{
		$sql .= $s.$key."='".$value."'";
		$s = ",";
	}
	$query = 'UPDATE '.TABLE_PRODUCT.' SET '.$sql.' WHERE productid='.$productid;
	$db->query($query);
	
	//生成html
	if($pdt['ishtml'])
	{
		$catid = $pdt['catid'];
		createhtml('index');
		createhtml('list');
		createhtml('show');
	}
	
	$query = "DELETE FROM ".TABLE_PRODUCT_PDTATT." WHERE productid=".$productid;
	$db->query($query);
	//插入属性表
	if(isset($pdt_att_ids) && isset($pdt_att_value))
	{
		$pdt_att_ids = unserialize(stripslashes($pdt_att_ids));
		if(is_array($pdt_att_value))
		{
			foreach ($pdt_att_value as $k=>$v)
			{
				if(!empty($v))
				{
					$query = "INSERT INTO ".TABLE_PRODUCT_PDTATT." (productid,att_id,att_value)".
							 "VALUES(".$productid.",".$pdt_att_ids[$k].",'".$v."')";
					$db->query($query);
				}
			}		
		}
	}

	//插入图片相册表
	$query = "DELETE FROM ".TABLE_PRODUCT_IMAGES." WHERE productid=".$productid;
	$db->query($query);
	foreach($productimage_url as $k=>$v)
	{
		if($v)
		{
			$thumb = '';
			if(strpos($v,'http')===false)
			{
				$thumb = str_replace(basename($v),'thumb_'.basename($v),$v);
			}
			$query = "INSERT INTO ".TABLE_PRODUCT_IMAGES." (imgurl,introduce,imgthumb,productid) ".
					 "VALUES('$v','".$productimage_intro[$k]."','$thumb',$productid)";
			$db->query($query);
		}		
	}
	if(isset($arrposid) || $old_arrposid)
	{
		$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
		$pos->edit($productid, $old_posid_arr, $arrposid);
	}
	showmessage($LANG['operation_success'],"?mod=$mod&file=product&action=manage");	
	
}
else
{
	require_once PHPCMS_ROOT."/$mod/include/formselect.func.php";
	$TYPE = cache_read('type_product.php');
	if(!$catid)
	{
		showmessage($LANG['select_category_and_add_product_there']);
	}
	$catid = intval($catid);	
	$CATE = cache_read('category_'.$catid.'.php');
	if(!(($CATE['enableadd'] || $CATE['child']==0) && !$CATE['islink']))
	{
		showmessage($LANG['external_category_or_top_category']);
	}
	$productid = isset($productid) ? intval($productid) : 0;
	if(!$productid)
	{
		showmessage($LANG['illegal_parameters'],$referer);
	}
	$query = "SELECT * FROM ".TABLE_PRODUCT." WHERE productid=".$productid." limit 0 ,1";
	$r = $db->get_one($query);
	$r = new_htmlspecialchars($r);
	@extract($r,EXTR_OVERWRITE);	
	$query = "SELECT * FROM ".TABLE_PRODUCT_IMAGES." WHERE productid=".$productid." ORDER BY Id ASC";
	$uploadimages = array();
	$res = $db->query($query);
	while($r = $db->fetch_array($res))
	{ 
		$uploadimages[] = $r;
	}
	$db->free_result($res);
	$style_edit = style_edit("pdt[style]",$style);
	$subtypeselect = type_select('pdt[subtype]',$LANG['select_sub_type'], $subtype);
	
	$brandselect = brand_select('',1,$brand_id);
	$brand_name = ($brand_id && array_key_exists($brand_id,$BRANDS)) ? $BRANDS[$brand_id]['brand_name'] : '';
	$producttypeselect = property_select('propertyselect',$LANG['select_product_property'],"onchange='LoadAttList(this.value);' id='propertyselect'",$pro_id);
	$htmlurlruleid = $ishtml ? $urlruleid : $MOD['item_html_urlruleid'];
	$phpurlruleid = $ishtml ?  $MOD['item_php_urlruleid'] : $urlruleid ;
	
	$html_urlrule = product_urlrule_select('html_urlrule','html','item',$htmlurlruleid);
	$php_urlrule = product_urlrule_select('php_urlrule','php','item',$phpurlruleid);
	$showskin = showskin('pdt[skinid]',$skinid);
	$showtpl = showtpl($mod,'content','pdt[templateid]',$templateid);
	$cat_pos = admin_catpos($catid);
	$position = $pos->checkbox('pdt[arrposid][]', $arrposid);
	include admintpl('product_edit');
}
?>