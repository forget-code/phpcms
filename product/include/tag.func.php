<?php
function product_list($templateid = '', $catid = 0, $brand_id =0 , $child = 1, $page = 0, $productnum = 10, $titlelen = 30, $descriptionlen = 0, $typeid=0,$posid=0, $datenum = 0, $ordertype = 0, $datetype = 0,$showcatname = 0, $showbrand=0,$showhits = 0,$showprice=1,$showmarketprice=1,$showcartlink=0,$showviewlink=0,$target = 0, $cols = 2,$fromprice=0,$toprice=0) 
{
	global $db, $MODULE, $PHP_TIME, $CATEGORY , $BRANDS, $skindir, $mod, $LANG;
	if($mod != 'product')
	{
	    $cat = cache_read('categorys_product.php');
		$BRANDS = cache_read('product_brands.php');
	}
	else
	{
	    $cat = $CATEGORY;
	}
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, productid DESC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC','sales DESC','sales ASC','comments DESC','comments ASC');
	$page = isset($page) ? intval($page) : 1;
	$fromprice = floatval($fromprice);
	$toprice = floatval($toprice);	
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$catids = $catid ;
	$brand_ids = $brand_id;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $cat[$catid]['arrchildid'];
	}
	$condition = $pages = '';
	if($posid)
	{
		$productids = @file_get_contents(PHPCMS_ROOT.'/'.$mod.'/pos/'.$posid.'.txt');
		if($productids) $condition .= " AND productid IN($productids)";
	}	
	$condition .= $catids ? (is_numeric($catids) ? " AND catid=$catid " : " AND catid IN ($catids) ") : '';
	$condition .= $typeid ? " AND subtype=$typeid " : '';
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $brand_ids ? (is_numeric($brand_ids) ? " AND brand_id=$brand_id " : " AND brand_id IN ($brand_ids) ") : '';
	$condition .= $fromprice ? " AND price>$fromprice " : '';
	$condition .= $toprice ? " AND price<$toprice " : '';
	$offset = $page ? ($page-1)*$productnum : 0;
	if($page && $productnum)
	{
		$r = $db->get_one("SELECT count(productid) AS number FROM ".TABLE_PRODUCT." WHERE disabled=0 AND onsale=1 $condition ","CACHE");
        $pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $productnum) : phppages($r['number'], $page, $productnum);
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $productnum ? " LIMIT $offset, $productnum " : 'LIMIT 0, 10';
	$products = array();
	$result = $db->query("SELECT productid,pdt_name,style,catid,subtype,brand_id,arrposid,pro_id,pdt_No,pdt_num,pdt_weight,pdt_unit,pdt_description,introduce,pdt_img,hits,price,showcommentlink,marketprice,addtime,edittime,onsale,disabled,ishtml,urlruleid,linkurl,listorder  FROM ".TABLE_PRODUCT." WHERE disabled=0  AND onsale=1 $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = date($datetypes[$datetype],$r['addtime']);
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['cut_pdt_name'] = str_cut($r['pdt_name'],$titlelen ,'...');
		$r['cut_pdt_name'] = style($r['cut_pdt_name'], $r['style']);
		$r['marketprice'] = strval($r['marketprice'])==='0.00' ? $LANG['unknown'] : $r['marketprice'];
		$r['pdt_description'] = str_cut($r['pdt_description'],$descriptionlen,'...');
		if($showcatname)
		{
			$r['catname'] = $cat[$r['catid']]['catname'];
			$r['catlinkurl'] = $cat[$r['catid']]['linkurl'];
		}
		if($showbrand)
		{
			$r['brandname'] = $BRANDS[$r['brand_id']]['brand_name'];
		}
		$products[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_product_list';
	include template('product', $templateid);
}

function product_thumb($templateid = '',$catid = 0,$brand_id =0 , $child = 1, $page = 0, $productnum = 10, $titlelen = 20, $descriptionlen = 100, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $showprice=1,$showmarketprice=1, $showcatname = 0,$showbrand=0,$showcartlink=0,$showviewlink=0,$target = 0, $imgwidth = 100, $imgheight = 100, $cols = 2,$fromprice=0,$toprice=0,$showtitle=1)
{
	global $db, $MODULE,$PHP_TIME,$CATEGORY,$BRANDS,$skindir,$mod,$MOD, $LANG;
	if($mod != 'product')
	{
	    $cat = cache_read('categorys_product.php');
		$BRANDS = cache_read('product_brands.php');
	}
	else
	{
	    $cat = $CATEGORY;
	}
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, productid DESC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC','sales DESC','sales ASC','comments DESC','comments ASC');
	$page = isset($page) ? intval($page) : 1;
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$catids = $catid ;
	$brand_ids = $brand_id;
	if($child && $catid && is_numeric($catid))
	{
		$catids = $cat[$catid]['arrchildid'];
	}
	$condition = $pages = '';
	if($posid)
	{
		$productids = @file_get_contents(PHPCMS_ROOT.'/'.$mod.'/pos/'.$posid.'.txt');
		if($productids) $condition .= " AND productid IN($productids)";
	}	
	$condition .= $catids ? (is_numeric($catids) ? " AND catid=$catid " : " AND catid IN ($catids) ") : '';
	$condition .= $typeid ? " AND subtype=$typeid " : '';
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $brand_ids ? (is_numeric($brand_ids) ? " AND brand_id=$brand_id " : " AND brand_id IN ($brand_ids) ") : '';
	$condition .= $fromprice ? " AND price>$fromprice " : '';
	$condition .= $toprice ? " AND price<$toprice " : '';	
	$offset = $page ? ($page-1)*$productnum : 0;
	if($page && $productnum)
	{
		$r = $db->get_one("SELECT count(productid) AS number FROM ".TABLE_PRODUCT." WHERE disabled=0  AND onsale=1 $condition ","CACHE");
        $pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $productnum) : phppages($r['number'], $page, $productnum);
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $productnum ? " LIMIT $offset, $productnum " : 'LIMIT 0, 10';
	$products = array();
	$result = $db->query("SELECT productid,pdt_name,style,catid,subtype,brand_id,arrposid,pro_id,pdt_No,pdt_num,pdt_weight,pdt_unit,pdt_description,introduce,pdt_img,hits,price,showcommentlink,marketprice,addtime,edittime,onsale,disabled,ishtml,urlruleid,linkurl,listorder  FROM ".TABLE_PRODUCT." WHERE disabled=0  AND onsale=1 $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$addtime = $r['addtime'];
		$r['addtime'] = date($datetypes[$datetype], $r['addtime']);
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['cut_pdt_name'] = str_cut($r['pdt_name'], $titlelen, '...');
		$r['cut_pdt_name'] = style($r['cut_pdt_name'], $r['style']);
		$r['marketprice'] = strval($r['marketprice'])==='0.00' ? $LANG['unknown'] : $r['marketprice'];
		$r['pdt_description'] = str_cut($r['pdt_description'] , $descriptionlen, '...');
		$r['pdt_img'] = imgurl($r['pdt_img']);
		if($showalt) $r['alt'] = $LANG['product'].':'.$r['pdt_name'].'&#10;'.$LANG['add'].':'.date('Y-m-d',$addtime).'&#10;'.$LANG['hits'].':'.$r['hits'];
		if($showcatname)
		{
			$r['catname'] = $cat[$r['catid']]['catname'];
			$r['catlinkurl'] = $cat[$r['catid']]['linkurl'];
		}
		if($showbrand)
		{
			$r['brandname'] = $BRANDS[$r['brand_id']]['brand_name'];
		}
		$products[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_product_thumb';
	include template('product', $templateid);
}

function product_slide($templateid = '',$catid = 0,$brand_id =0 , $child = 1, $productnum = 5, $titlelen = 30, $typeid=0, $posid=0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1)
{
	global $db, $MODULE, $PHP_TIME,$CATEGORY,$BRANDS,$skindir,$mod;
	if($mod != 'product')
	{
	    $cat = cache_read('categorys_product.php');
		$BRANDS = cache_read('product_brands.php');
	}
	else
	{
	    $cat = $CATEGORY;
	}
	$ordertypes = array('listorder DESC, productid DESC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC','sales DESC','sales ASC','comments DESC','comments ASC');
	$page = isset($page) ? intval($page) : 1;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;	
	$condition = '';
	$catids = $catid ;
	$brand_ids = $brand_id;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $CATEGORY[$catid]['arrchildid'];
	}
	$condition = '';
	if($posid)
	{
		$productids = @file_get_contents(PHPCMS_ROOT.'/'.$mod.'/pos/'.$posid.'.txt');
		if($productids) $condition .= " AND productid IN($productids)";
	}
	
	$condition .= $catids ? (is_numeric($catids) ? " AND catid=$catid " : " AND catid IN ($catids) ") : '';
	$condition .= $typeid ? " AND subtype=$typeid " : '';
	$condition .= $brand_ids ? (is_numeric($brand_ids) ? " AND brand_id=$brand_id " : " AND brand_id IN ($brand_ids) ") : '';
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $productnum ? " LIMIT 0, $productnum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = 'imgUrl0';
	$flash_links = 'imgLink0';
	$flash_texts = 'imgtext0';
	$products = array();
	$result = $db->query("SELECT productid,catid,pdt_name,style,introduce,hits,pdt_img,addtime,arrposid,listorder,ishtml,urlruleid,linkurl FROM ".TABLE_PRODUCT." WHERE disabled=0 AND pdt_img!='' $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['pdt_name'] = addslashes(str_cut($r['pdt_name'], $titlelen, '...'));
		$r['pdt_img'] = imgurl($r['pdt_img']);
		$r['flashpic'] = preg_match("/\.(jpg|jpeg)$/i",$r['pdt_img']) ? $r['pdt_img'] : PHPCMS_PATH.'images/focus.jpg';
		if($k)
		{
			$flash_pics.="+\"|\"+imgUrl".$k;
			$flash_links.="+\"|\"+imgLink".$k;
			$flash_texts.="+\"|\"+imgtext".$k;
		}
		$k++;
		$products[] = $r;
	}
	$db->free_result($result);
	if(!$products)
	{
		$products[0]['pdt_img'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$products[0]['url']= $flash_links = '#';
		$products[0]['pdt_name'] = $flash_texts = '';
	}
	$timeout = $timeout*1000;
	$templateid = $templateid ? $templateid : 'tag_product_slide';
	include template('product', $templateid);
}
?>