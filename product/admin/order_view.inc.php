<?php
defined('IN_PHPCMS') or exit('Access Denied');


require PHPCMS_ROOT.'/member/admin/include/member_admin.class.php';

$odr_id = intval($odr_id);
$query = "SELECT * FROM ".TABLE_PRODUCT_ORDER." WHERE odr_id =".$odr_id;
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


//获取商品
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

//获取用户信息
$member = new member_admin();
$memberinfo = $member->view('m.userid='.$odr_info['memberid']);
$odr_info = array_merge($odr_info,$memberinfo);
unset($memberinfo);
$discount = sprintf('%.2f',$odr_info['discount']/100);

if(isset($isprint) && $isprint=='1')
{
	include admintpl('order_print');
}
else 
{
	include admintpl('order_view');
}
?> 