<?php

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($mod);

if(isset($submit))
{ 
	//检查浏览器输入
	if(empty($pdt['pdt_name']))
	{
		showmessage($LANG['product_name_not_null'],'goback');
	}
	$pdt['catid'] = intval($pdt['catid']);
	if($pdt['catid'] == 0)
	{
		showmessage($LANG['select_product_category'],"?mod=$mod&file=category&action=manage");
	}
	if(empty($pdt['price']))
	{
		showmessage($LANG['product_price_not_null'],'goback');
	}
	if(numberval($pdt['price'])===false)
	{
		showmessage($LANG['product_price_format_error'],'goback');
	}
	//判断商品重复
	$checkrepeatsql="SELECT pdt_name FROM ".TABLE_PRODUCT." WHERE pdt_name='".$pdt['pdt_name']."'";
	$db->query($checkrepeatsql);
	if($db->affected_rows()>0)
	{
		showmessage($LANG['product_name_repeat_refill'],$referer);
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
	//处理url规则
	if($pdt['ishtml'])
	{
		$pdt['urlruleid']=$html_urlrule;
	}
	else 
	{
		$pdt['urlruleid']=$php_urlrule;
	}
	//赋值处理
	$pdt['subtype'] = intval($pdt['subtype']);
	$pdt['pro_id'] = intval($propertyselect);
	$pdt['price'] = sprintf('%01.2f',$pdt['price']);
	$pdt['marketprice'] = sprintf('%01.2f',$pdt['marketprice']);
	$pdt['pdt_weight'] = sprintf('%01.3f',$pdt['pdt_weight']);
	$pdt['hits'] = 0;
	$pdt['addtime'] = $PHP_TIME;
	$pdt['onsale'] = intval($pdt['onsale'])==1 ? 1 : 0;
	$pdt['brand_id'] = $brandid; 
	$pdt['urlruleid'] = $pdt['ishtml'] ? $html_urlrule : $php_urlrule;
	unset($pdt['pdt_brand']);
	if(isset($pdt['arrposid']))
	{
		$arrposid = $pdt['arrposid'];
		$pdt['arrposid'] = ','.implode(',', $arrposid).',';
	}
	if(strpos($pdt['pdt_img'],'http')===false)
	{
		$pdt['pdt_thumb'] = str_replace(basename($pdt['pdt_img']),'thumb_'.basename($pdt['pdt_img']),$pdt['pdt_img']);
	}
	$keys = $values = $s = "";
	foreach($pdt as $key => $value)
	{
		$keys .= $s.$key;
		$values .= $s."'".$value."'";
		$s = ",";
	}   
	$db->query("insert into ".TABLE_PRODUCT." ($keys) values($values)");
	$productid = $db->insert_id();
	
	//插入属性表
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
	
	//插入图片相册表
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

	//生成URl规则
	$linkurl = item_url('url', $pdt['catid'], $pdt['ishtml'], $pdt['urlruleid'], $pdt['htmldir'], $pdt['prefix'], $productid, $pdt['addtime']);
	$db->query("UPDATE ".TABLE_PRODUCT." SET linkurl='$linkurl' WHERE productid=$productid");
	
	if($pdt['ishtml'])
	{
		$catid = $pdt['catid'];
		createhtml('index');
		createhtml('list');
		createhtml('show');
	}
	
	if($productid)
	{
		if(isset($arrposid) && $arrposid) $pos->add($productid, $arrposid);
		showmessage($LANG['operation_success'],$referer);
	}
}
else
{
	require_once PHPCMS_ROOT."/$mod/include/formselect.func.php";
	$TYPE = cache_read('type_product.php');
	if(!$catid)
	{
		showmessage($LANG['select_category_and_add_product_there'],"?mod=$mod&file=category&action=manage");
	}
	$catid = intval($catid);	
	$CATE = cache_read('category_'.$catid.'.php');
	if(!(($CATE['enableadd'] || $CATE['child']==0) && !$CATE['islink']))
	{
		showmessage($LANG['external_category_or_top_category'],"?mod=$mod&file=category&action=manage");
	}
	$style_edit = style_edit("pdt[style]","");
	
	$subtypeselect = type_select('pdt[subtype]', $LANG['select_sub_type']);
	//$subtypeselect = type_select($MOD['typeids'], $name = 'pdt[subtype]', $alt = '选择附属类别', 0); //附属栏目选择
	$brandselect = brand_select('',1);	//品牌选择
	$relatedtype = ($CATE['relatedtype']) ? $CATE['relatedtype'] : 1;
	$producttypeselect = property_select('propertyselect',$LANG['select_product_property'],"onchange='LoadAttList(this.value);' id='propertyselect'",$relatedtype);
	$html_urlrule = product_urlrule_select('html_urlrule','html','item',$CATE['item_html_urlruleid']);
	$php_urlrule = product_urlrule_select('php_urlrule','php','item',$CATE['item_php_urlruleid']);
	$showskin = showskin('pdt[skinid]','product');
	$showtpl = showtpl($mod,'content','pdt[templateid]');
	$cat_pos = admin_catpos($catid);
	$position = $pos->checkbox('pdt[arrposid][]');
	include admintpl('product_add');
}
?> 