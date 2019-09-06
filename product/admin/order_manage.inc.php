<?php
defined('IN_PHPCMS') or exit('Access Denied');


$username = isset($username) ? $username : '';
$odr_id = isset($odr_id) ? $odr_id : '';
$truename = isset($truename) ? $truename : '';
$pdt_name = isset($pdt_name) ? $pdt_name : '';
$pdt_No = isset($pdt_No) ? $pdt_No : '';
$province = isset($province) ? $province : '';
$city = isset($city) ? $city : '';
$area = isset($area) ? $area : '';
$address = isset($address) ? $address : '';
$telephone = isset($telephone) ? $telephone : '';
$mobile = isset($mobile) ? $mobile : '';
$email = isset($email) ? $email : '';
$frompayment = isset($frompayment) ? $frompayment : '';
$topayment = isset($topayment) ? $topayment : '';
if($dosubmit)
{
	$begintime = strtotime($begindate);	
	$endtime = strtotime($enddate);
	$query = "SELECT pdt.productid,pdt.pdt_name,pdt.style,pdt.catid,pdt.subtype  ,pdt.brand_id  ,pdt.pro_id  ,pdt.pdt_No  ,pdt.pdt_num  ,pdt.pdt_weight  ,pdt.pdt_unit ,pdt.pdt_img,pdt.hits  ,pdt.showcommentlink  ,pdt.price  ,pdt.marketprice  ,pdt.pdt_keyword  ,pdt.pdt_description  ,pdt.addtime  ,pdt.edittime  ,pdt.onsale  ,pdt.disabled,pdt.listorder,".
			"cart.cart_id, cart.odr_id, cart.user_id, cart.productid, cart.pdt_No, cart.pdt_name, cart.pdt_number, ".
			"odr.odr_id, odr.odr_No, odr.memberid, odr.truename, odr.province, odr.city, odr.area, odr.address, odr.zipcode, odr.email, odr.telephone, odr.mobile, odr.order_num, odr.isverify, odr.isship, odr.ispay, odr.paytype,m.userid,m.username ".
			" FROM ".TABLE_PRODUCT." pdt, ".TABLE_PRODUCT_ORDER." odr ,".TABLE_MEMBER." m,".TABLE_PRODUCT_CART." cart WHERE odr.memberid=m.userid=odr.memberid AND cart.odr_id=odr.odr_id AND cart.productid=pdt.productid";
	$con = '';
	$con.= $username=='' ? '':" AND m.username = '$username' ";
	$con.= $odr_No=='' ? '':" AND odr.odr_No = '$odr_No' ";
	$con.= $truename=='' ? '':" AND odr.truename LIKE '%$truename%' ";
	$con.= (empty($province) || $province ==$LANG['no_limit']) ? '':" AND odr.province='$province' ";
	$con.= (empty($city) || $city==$LANG['no_limit']) ? '':" AND odr.city='$city' ";	
	$con.= (empty($area) || $area==$LANG['no_limit']) ? '':" AND odr.area='$area' ";
	$con.= $address == '' ? '':" AND odr.address LIKE '%$address%' ";
	$con.= $telephone == '' ? '':" AND odr.telephone = '$telephone' ";
	$con.= $mobile == '' ? '':" AND odr.mobile = '$mobile' ";
	$con.= $email == '' ? '':" AND odr.email = '$email' ";
	$con.= !isset($isverify) || $isverify == '' ? '':" AND odr.isverify = $isverify ";
	$con.= !isset($ispay) || $ispay == '' ? '':" AND odr.ispay = $ispay ";
	$con.= !isset($isship) || $isship ==''  ? '':" AND odr.isship = $isship ";
	$con.= " AND odr.addtime>$begintime  AND odr.addtime < $endtime ";
	$query.= $con;
	
	$pagesize = isset($pagesize) ? $pagesize : $PHPCMS['pagesize'];
	$page = isset($page) ? intval($page) : 1;
	$offset = ($page-1)*$pagesize;
	$result = $db->query($query);
	//$r = $db->fetch_array($result);
	$number = $db->num_rows($result);
	//$number = $r['num'];
	$pages  = phppages($number,$page,$pagesize);
	$odrs = array();
	$query =$query." order by odr.odr_id desc limit $offset,".$pagesize;	
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = date("y-m-d H:i",$r['addtime']);
		$r['isverify'] = $r['isverify']==1 ? $LANG['verified'] : $LANG['not_verified'];
		$r['isship'] = $r['isship']==1 ? $LANG['shipped'] : $LANG['not_shipped'];
		$r['ispay'] = $r['ispay']==1 ? $LANG['paid'] : $LANG['not_paid'];
		$odrs[] = $r;
	}
	include admintpl('order_manage');
	
}
else 
{
	$begindate = '2006-01-01';
    $enddate = '2009-12-30';
	$srchtype = isset($srchtype) ? intval($srchtype) : 0;
	$keywords = isset($keywords) ? $keywords : '';
	$sql = '';
	if(!empty($keywords))
	{
		$keyword = preg_replace('/[ |*]/','%',$keywords);
		$srchtypes = array(" AND odr_No LIKE '%$keyword%'", " AND pdt_No LIKE '%$keyword%' ");
		$sql.=$srchtypes[$srchtype];
	}
	$pagesize = isset($pagesize) ? $pagesize : $PHPCMS['pagesize'];
	$page = isset($page) ? intval($page) : 1;
	$offset = ($page-1)*$pagesize;
	$result = $db->query("SELECT count(*) as num FROM ".TABLE_PRODUCT_ORDER." WHERE disabled=0 ".$sql);
	
	$r = $db->fetch_array($result);
	$number = $r['num'];
	$pages  = phppages($number,$page,$pagesize);
	$odrs = array();
	$query ="SELECT odr_id,odr_No,truename,province,city,address,zipcode,email,telephone,mobile,isverify,verifytime,isship,shiptime,ispay,paytime,disabled,addtime  ".
			"FROM ".TABLE_PRODUCT_ORDER.
			" WHERE disabled=0  $sql order by odr_id desc limit $offset,".$pagesize;
	
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = date("y-m-d H:i",$r['addtime']);
		$r['isverify'] = $r['isverify']==1 ? $LANG['verified'] : $LANG['not_verified'];
		$r['isship'] = $r['isship']==1 ? $LANG['shipped'] : $LANG['not_shipped'];
		$r['ispay'] = $r['ispay']==1 ? $LANG['paid'] : $LANG['not_paid'];
		$odrs[] = $r;
	}
	include admintpl('order_manage');
}
?> 