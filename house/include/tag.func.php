<?php
function display_list($templateid = '', $areaid='',$develop='',$startpricestart=0,$startpriceend=0,$avgpricestart=0,$avgpriceend=0,$page = 0, $displaynum = 10, $titlelen = 30, $descriptionlen = 0, $typeid=0,$posid=0, $datenum = 0, $ordertype = 0, $datetype = 0, $showhits = 0,$showareaname=1,$showprice=1,$target = 0, $cols = 2) 
{
	global $db, $MODULE, $PHP_TIME,$MOD, $skindir, $LANG,$AREA;
	if($mod != 'house')
	{
	    $PARS = include_once PHPCMS_ROOT.'/house/include/pars.inc.php';
	}
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, displayid DESC', 'displayid DESC', 'displayid ASC', 'hits DESC', 'hits ASC','comments DESC','comments ASC','startprice DESC','startprice ASC','avgprice DESC','avgprice ASC');
	$page = isset($page) ? intval($page) : 1;
	$startpricestart = floatval($startpricestart);
	$startpriceend = floatval($startpriceend);
	$avgpricestart = floatval($avgpricestart);
	$avgpriceend = floatval($avgpriceend);
	
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 10) $ordertype = 0;

	$condition = $pages = '';

	$displaypages = 1;

	if($posid)
	{
		$displayids = @file_get_contents(PHPCMS_ROOT.'/house/pos/'.$posid.'.txt');
		if($displayids) $condition .= " AND displayid IN($displayids)";
	}
	if($areaid)
	{
		$arrchildid = $AREA[$areaid]['arrchildid'];
		$condition .= $AREA[$areaid]['child'] ? " AND areaid IN ($arrchildid) " : " AND areaid=$areaid ";
		$displaypages = 0;
	}
	$condition .= $typeid ? " AND subtype=$typeid " : '';
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $startpricestart ? " AND startprice>$startpricestart " : '';
	$condition .= $startpriceend ? " AND startprice<$startpriceend " : '';
	$condition .= $avgpricestart ? " AND avgprice>$avgpricestart " : '';
	$condition .= $avgpriceend ? " AND avgprice<$avgpriceend " : '';
	$offset = $page ? ($page-1)*$displaynum : 0;
	$displaynum = $displaynum?$displaynum:10;
	if($page && $displaynum)
	{
		$r = $db->get_one("SELECT count(displayid) AS number FROM ".TABLE_HOUSE_DISPLAY." WHERE status=1 $condition ","CACHE");
        $pages = $displaypages ? displaypages($r['number'], $page, $displaynum) : phppages($r['number'], $page, $displaynum);
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $displaynum ? " LIMIT $offset, $displaynum " : 'LIMIT 0, 10';
	$displays = array();
	$result = $db->query("SELECT * FROM ".TABLE_HOUSE_DISPLAY." WHERE status=1 $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = date($datetypes[$datetype],$r['addtime']);
		$r['linkurl'] = linkurl($r['linkurl'], 1);
		$r['cut_name'] = str_cut($r['name'],$titlelen ,'...');
		$r['cut_name'] = style($r['cut_name'], $r['style']);
		$r['avgprice'] = strval($r['avgprice'])==='0.00' ? $LANG['unknown'] : $r['avgprice'];
		$r['startprice'] = strval($r['startprice'])==='0.00' ? $LANG['unknown'] : $r['startprice'];
		$r['introduce'] = str_cut($r['introduce'], $descriptionlen, '...');
		$r['image'] = imgurl($r['image']);
		$r['thumb'] = imgurl($r['thumb']);
		$r['img1'] = imgurl($r['img1']);
		$r['img2'] = imgurl($r['img2']);
		$r['img3'] = imgurl($r['img3']);
		$displays[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_display_list';
	include template('house', $templateid);
}

function house_list($templateid = '', $infocat=1,$areaid='',$pricestart=0,$priceend=0,$page = 0, $housenum = 10, $titlelen = 30, $descriptionlen = 0, $typeid=0,$posid=0, $datenum = 0, $ordertype = 0, $datetype = 0, $showhits = 0,$showareaname=1,$showprice=1,$target = 0, $cols = 2,$username=0) 
{
	global $db, $MODULE, $PHP_TIME, $skindir,$MOD, $LANG;
	$PARS = include PHPCMS_ROOT.'/house/include/pars.inc.php';
	//$TYPES = array_flip($PARS['infotype']);
	$DECORATES = array_flip($PARS['decorate']);
	$TOWARDS = array_flip($PARS['towards']);
	$HOUSETYPE = array_flip($PARS['type']);
	$INFRASTRUCTURE = array_flip($PARS['infrastructure']);
	$INDOOR = array_flip($PARS['indoor']);
	$PERIPHERAL = array_flip($PARS['peripheral']);
	$AREA = cache_read('areas_house.php');

	if($mod != 'house')
	{
	    $PARS = include_once PHPCMS_ROOT.'/house/include/pars.inc.php';
	}
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, houseid DESC', 'houseid DESC', 'houseid ASC', 'hits DESC', 'hits ASC','comments DESC','comments ASC','price DESC','price ASC');
	$page = isset($page) ? intval($page) : 1;
	$pricestart = floatval($pricestart);
	$priceend = floatval($priceend);

	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 10) $ordertype = 0;

	$condition = $pages = '';

	$housepages = 1;

	if($posid)
	{
		$houseids = @file_get_contents(PHPCMS_ROOT.'/house/pos/'.$posid.'.txt');
		if($houseids) $condition .= " AND houseid IN($houseids)";
	}
	if($areaid)
	{
		$arrchildid = $AREA[$areaid]['arrchildid'];
		$condition .= $AREA[$areaid]['child'] ? " AND areaid IN ($arrchildid) " : " AND areaid=$areaid ";
		$housepages = 0;
	}
	$condition .= $infocat ? " AND infocat=$infocat " : '';
	$condition .= $typeid ? " AND subtype=$typeid " : '';
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $pricestart ? " AND price>$pricestart " : '';
	$condition .= $priceend ? " AND price<$priceend " : '';
	$condition .= $username ? " AND username='$username'" : '';
	$offset = $page ? ($page-1)*$housenum : 0;
	if($page && $housenum)
	{
		$r = $db->get_one("SELECT count(houseid) AS number FROM ".TABLE_HOUSE." WHERE status=1 $condition ","CACHE");
        $pages = $housepages ? housepages($infocat, $r['number'], $page, $housenum) : phppages($r['number'], $page, $housenum);
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $housenum ? " LIMIT $offset, $housenum " : 'LIMIT 0, 10';
	$houses = array();
	$result = $db->query("SELECT *  FROM ".TABLE_HOUSE." WHERE status=1 $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = date($datetypes[$datetype],$r['addtime']);
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['infocatname'] = $PARS['infotype']['type_'.$r['infocat']];
		$r['cut_name'] = str_cut($r['name'],$titlelen ,'...');
		$r['cut_name']= $r['cut_name']?$r['cut_name']:'房产信息';
		$r['cut_name'] = style($r['cut_name'], $r['style']);		
		$r['price'] = strval($r['price'])==='0.00' ? $LANG['unknown'] : $r['price'];
		$r['price'] = strval($r['price'])==='0.00' ? $LANG['unknown'] : $r['price'];
		$r['description'] = str_cut($r['description'],$descriptionlen,'');
		$r['img1'] = $r['img1'] ? $r['img1']:"images/nopic.gif";
		$r['img2'] = $r['img2'] ? $r['img2']:"images/nopic.gif";
		$r['img3'] = $r['img3'] ? $r['img3']:"images/nopic.gif";
		$r['img4'] = $r['img4'] ? $r['img4']:"images/nopic.gif";		
		switch ($r['isinter'])
		{
			case 1:
			$r['isinter'] = '个人';
			break;
			
			case 2:
			$r['isinter'] = '中介';
			break;
			
			case 3:
			$r['isinter'] = '开发商';
			break;
			
			default:
			$r['isinter'] = '个人';
			break;
		}
		$housetypearr = explode(",",$r['housetype']);
		$r['housetype'] = '';
		$stw = array('室','厅','卫','阳台');
		foreach ($housetypearr as $k=>$v)
		{
			$r['housetype'].=$v=='不限'?'':$v.$stw[$k];
		}
		$houses[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_house_list';
	include template('house', $templateid);
}


function member_list($templateid = '', $membertype=2, $membernum=10, $page = 0, $ordertype = 0,$target = 0) 
{
	
	global $db, $MOD,$MODULE, $PHP_TIME, $skindir, $LANG,$AREA,$PARS;
	if($mod != 'house')
	{
	    $PARS = include_once PHPCMS_ROOT.'/house/include/pars.inc.php';
	}
	$page = isset($page) ? intval($page) : 1;
	$ordertypes = array('m.userid DESC', 'm.userid ASC', 'm.point DESC', 'm.point ASC');
	if($ordertype < 0 || $ordertype > 3) $ordertype = 0;

	$condition = '';	
	$ordertype = $ordertypes[$ordertype];
	if($page && $membernum)
	{
		$r = $db->get_one("SELECT count(*) as number FROM ".TABLE_MEMBER_INFO." mi,".TABLE_MEMBER." m WHERE mi.userid=m.userid AND mi.my_house_membertype=$membertype $condition","CACHE");
        $pages = phppages($r['number'], $page, $membernum);
	}
	$limit = $membernum ? " LIMIT 0,$membernum " : 'LIMIT 0, 10';
	$members = array();
	$result = $db->query("SELECT * FROM ".TABLE_MEMBER_INFO." mi,".TABLE_MEMBER." m WHERE mi.userid=m.userid AND mi.my_house_membertype=$membertype $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['lastlogintime'] = date('Y-m-d H:i', $r['lastlogintime']);
		$r['regdate'] = date('Y-m-d', $r['regtime']);
		$members[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$templateid = $templateid ? $templateid : 'tag_member_list';
	include template('house', $templateid);
}
?>