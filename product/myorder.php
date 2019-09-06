<?php 
require './include/common.inc.php';

$head['title'] = $LANG['my_order'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

if(!$_userid)
{
	showmessage($LANG['login_website'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
}

$action = isset($action) ? $action : 'manage';
$actions = array('add','edit','pay','delete','vieworder','manage');
if(!in_array($action,$actions))
{
	showmessage($LANG['illegal_operation'],$PHP_REFERER);	
}

if($action == 'manage')
{
	$pagesize = isset($pagesize) ? $pagesize : $PHPCMS['pagesize'];
	$page = isset($page) ? intval($page) : 1;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT count(*) as num  FROM ".TABLE_PRODUCT_ORDER." WHERE memberid=".$_userid);
	$number = $r['num'];
	$pages  = phppages($number,$page,$pagesize);
	$query = 'SELECT *'.
			 ' FROM '.TABLE_PRODUCT_ORDER.' WHERE memberid='.$_userid.' ORDER BY odr_id desc limit '.$offset.','.$pagesize;
	$result = $db->query($query);
	//$allamount = 0;
	$orders = array();
	while($r = $db->fetch_array($result))
	{
		$r['isverify'] = $r['isverify'] == 1 ? $LANG['verified'] : '<span class="noverify">'.$LANG['not_verified'].'</span>';
		$r['ispay'] = $r['ispay']==1 ? $LANG['paid'] : '<span class="nopay">'.$LANG['not_paid'].'</span>';
		$r['isship'] = $r['isship']==1 ? $LANG['shipped'] : '<span class="noship">'.$LANG['not_shipped'].'</span>';
		$r['addtime'] = date('Y-m-d H:i:s',$r['addtime']);
		$orders[] =$r;		
		//$allamount += $r['singleamount'];
	}	
	include template($mod,'myorder');
}
else if($action == 'vieworder')
{
	$odr_id = intval($odr_id);
	$odr_id or showmessage($LANG['illegal_operation']);
	$query = "SELECT * FROM ".TABLE_PRODUCT_ORDER." o ,".TABLE_MEMBER." m  WHERE o.odr_id =".$odr_id." AND o.memberid=m.userid";
	$odr_info = $db->get_one($query);
	if($odr_info['isverify']) 
	{
		$odr_info['isverify'] = $LANG['verified'];
		$odr_info['verifytime'] = date("Y-m-d H:i:s",$odr_info['verifytime']);
	}
	else 
	{
		$odr_info['isverify'] = $LANG['not_verified'];
		$odr_info['verifytime'] = '';
	}
	if($odr_info['isship']) 
	{
		$odr_info['isship'] = $LANG['shipped'];
		$odr_info['shiptime'] = date("Y-m-d H:i:s",$odr_info['shiptime']);
	}
	else 
	{
		$odr_info['isship'] = $LANG['not_shipped'];
		$odr_info['shiptime'] = '';
	}
	if($odr_info['ispay'])
	{
		$odr_info['ispay'] = $LANG['paid'];
		$odr_info['paytime'] = date("Y-m-d H:i:s",$odr_info['paytime']);
	}
	else 
	{
		$odr_info['ispay'] = $LANG['not_paid'];
		$odr_info['paytime'] = '';
	}
	if($odr_info['addtime']) $odr_info['addtime'] = date("Y-m-d H:i:s",$odr_info['addtime']);
	$odr_info = new_htmlspecialchars($odr_info);	
	
	$odr_pdts = array();
	$total_mount = 0;
	$query = "SELECT * FROM ".TABLE_PRODUCT_CART." c,".TABLE_PRODUCT." p WHERE c.productid = p.productid  AND odr_id =".$odr_id;
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$r['item_total'] = sprintf('%.2f',$r['price']*$r['pdt_number']);
		$total_mount+=$r['item_total'];
		$odr_pdts[]=$r;
	}
	$total_mount = sprintf('%.2f',$total_mount);
	$odr_pdts = new_htmlspecialchars($odr_pdts);
	include template($mod,'vieworder');
}


?>