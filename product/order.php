<?php 

include_once './include/common.inc.php';
include_once PHPCMS_ROOT.'/include/mail.inc.php';

if(!$_userid)
{
	showmessage($LANG['login_website'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
}
$action = $action ? $action : 'show';
$actions = array('add','pay','showpay');
if(!in_array($action,$actions))
{
	showmessage($LANG['illegal_action'],$PHP_REFERER);	
}

if($action == 'add')
{
	$head['title'] = $LANG['generate_order'];
	$head['keywords'] = $MOD['seo_keywords'];
	$head['description'] = $MOD['seo_description'];
	$query = 'SELECT truename,province,city,area,telephone,mobile,address,postid,note,email FROM '.TABLE_MEMBER_INFO.' mi,'.TABLE_MEMBER.' m '.
			 ' WHERE m.userid='.$_userid.' AND mi.userid='.$_userid;
	@extract($db->get_one($query),EXTR_OVERWRITE);
	
	$micro = explode(" ",microtime());
	$odr_No = date('ymd',$micro[1]).substr($micro[1],6,4).substr($micro[0],2,6);
	$query = "INSERT INTO ".TABLE_PRODUCT_ORDER." ( `odr_No` , `memberid` , `truename` , `province` , `city` , `area`, `address` , `zipcode` , `email` , `telephone` , `mobile`, `isverify` , `verifytime` , `isship` , `shiptime` , `ispay` , `paytime` ,`paytype`,`disabled`,`addtime`,`note` ) 
			  VALUES ( '$odr_No', '$_userid', '$truename', '$province', '$city','$area', '$address', '$postid', '$email', '$telephone', '$mobile', '0', '0', '0', '0', '0', '0','','0','$PHP_TIME', '$note')";
	$db->query($query);
	$odr_id = $db->insert_id();
	$query = "UPDATE ".TABLE_PRODUCT_CART." SET odr_id='$odr_id'  where user_id=$_userid and odr_id=0 ";
	$db->query($query);

	if($MOD['issendemail']) 
	{
		ob_start();
		include template($mod,'ordermailtpl');
		$data = ob_get_contents();
		ob_clean();	
		sendmail($email,$LANG['order_confirm_mail'].$PHPCMS['sitename'],stripslashes($data));
	}	
	showmessage($LANG['order_added_next_payonline'],PHPCMS_PATH.$mod."/order.php?odr_id=$odr_id&action=showpay");	
}
else if($action == 'showpay')
{
	$odr_id = intval($odr_id);
	$odr_id or showmessage($LANG['illegal_operation']);
	$_money = sprintf('%.2f',$_money);
	
	$head['title'] = $LANG['begin_pay'];
	$head['keywords'] = $MOD['seo_keywords'];
	$head['description'] = $MOD['seo_description'];
	
	$odr_pdts = array();
	$total_mount = 0;
	$query = "SELECT cart.cart_id,cart.pdt_number,p.price FROM ".TABLE_PRODUCT_CART." cart,".TABLE_PRODUCT." p WHERE cart.productid=p.productid AND odr_id =".$odr_id;
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$total_mount+=$r['price']*$r['pdt_number'];
	}
	$total_mount = sprintf('%.2f',$total_mount);
	$member_mount =$discount*$total_mount;
	$amount = 0;
	if($total_mount>$_money) $amount = $total_mount-$_money;
	include template($mod,'showpay');
}
else if($action == 'pay')
{
	include_once PHPCMS_ROOT.'/pay/include/pay.func.php';
	$odr_id = intval($odr_id);
	$odr_id or showmessage($LANG['illegal_operation']);
	
	$head['title'] = $LANG['order_payment'];
	$head['keywords'] = $MOD['seo_keywords'];
	$head['description'] = $MOD['seo_description'];
	
	$r = $db->get_one("Select ispay from ".TABLE_PRODUCT_ORDER."  where odr_id=".$odr_id);
	if($r['ispay']) showmessage($LANG['you_have_payed']);
	
	$odr_pdts = array();
	$total_mount = 0;
	$query = "SELECT cart.cart_id,cart.pdt_number,odr.memberid,odr.odr_No,odr.odr_id,pdt.productid,pdt.price FROM ".TABLE_PRODUCT_CART." cart,".TABLE_PRODUCT_ORDER." odr,".TABLE_PRODUCT." pdt".
			" WHERE cart.odr_id =odr.odr_id AND pdt.productid=cart.productid AND odr.odr_id=".$odr_id;
	$result = $db->query($query);
	$odrNo = $odr_id;
	while($r = $db->fetch_array($result))
	{
		if($r['memberid']!=$_userid)  showmessage($LANG['not_your_order']);
		$odrNo = $r['odr_No'];
		$total_mount+= $r['price']*$r['pdt_number'];
	}
	if($_money<$total_mount) 
	{
		showmessage($LANG['account_balance_charge']);
	}
	$note = $MOD['name']."\r\n".$LANG['order_number'].":$odrNo";
	if(money_diff($_username, $total_mount, $note, $odrNo)) 
	{
		$query = 'UPDATE '.TABLE_PRODUCT_ORDER.' SET ispay=1,paytime='.$PHP_TIME.' WHERE odr_id='.$odr_id;
		$db->query($query);	
		$query ="SELECT odr_id,productid,pdt_number FROM ".TABLE_PRODUCT_CART." WHERE odr_id=".$odr_id;
		$result = $db->query($query);
		while ($r = $db->fetch_array($result))
		{
			$db->query("UPDATE ".TABLE_PRODUCT." SET sales=sales+".$r['pdt_number']." WHERE productid=".$r['productid']);
		}
		showmessage($LANG['pay_success_wait_product'], $MOD['linkurl'].'myorder.php');	
	}
}
?>