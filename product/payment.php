<?php 
include_once './include/common.inc.php';

if(!$_userid)
{
	showmessage($LANG['login_website'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
}
$action = isset($action) ? $action : 'checkaddress';
$actions = array('checkaddress','editaddress','showorder');
if(!in_array($action,$actions))
{
	showmessage($LANG['illegal_operation'],$PHP_REFERER);	
}

if($action == 'checkaddress')
{
	$num = intval($num);
	if(!$num)
	{
		showmessage($LANG['not_select_product'],PHPCMS_PATH.$mod.'/');	
	}
	$head['title'] = $LANG['confirm_address'];
	$head['keywords'] = $MOD['seo_keywords'];
	$head['description'] = $MOD['seo_description'];
	
	$query = 'SELECT truename,province,city,area,telephone,mobile,address,postid,note,email FROM '.TABLE_MEMBER_INFO.' mi,'.TABLE_MEMBER.' m '.
			 ' WHERE m.userid='.$_userid.' AND mi.userid='.$_userid;
	@extract($db->get_one($query));	
	
	if(!$province)
	{
		$province=$PHPCMS['province'];
	}
	if(!$city)
	{
		$city=$PHPCMS['city'];
	}
	if(!$area)
	{
		$area=$PHPCMS['area'];
	}
	
	include template($mod,'checkaddress');
	exit();
}
else if($action == 'showorder')
{
	$head['title'] = $LANG['confirm_order'];
	$head['keywords'] = $MOD['seo_keywords'];
	$head['description'] = $MOD['seo_description'];
	
	if(!is_email($checkaddress['email'])) showmessage($LANG['input_valid_email'],"goback");
	if(strlen($checkaddress['truename'])<2) showmessage($LANG['truename_2char_at_least'],"goback");
	if(!preg_match("/^[0-9\-\(\)]{6,15}$/",$checkaddress['telephone'])) showmessage($LANG['input_valid_telephone'],"goback");
	if(!$checkaddress['address']) showmessage($LANG['input_detail_address'],"goback");
	$checkaddress = new_htmlspecialchars($checkaddress);
	@extract($checkaddress,EXTR_OVERWRITE);
	$query = "UPDATE ".TABLE_MEMBER_INFO." SET truename='$truename',province='$province',city='$city',area='$area',telephone='$telephone',mobile='$mobile',address='$address',postid='$postid',note='$note' WHERE userid=$_userid";
	$db->query($query);
	
	$query = "UPDATE ".TABLE_MEMBER." SET email='$email' WHERE userid = $_userid";
	$db->query($query);
	
	$result=$db->query("SELECT * FROM ".TABLE_PRODUCT_CART." where user_id=$_userid AND odr_id=0 order by cart_id desc");
	$total_mount = 0;
	while($r = $db->fetch_array($result))
	{
		$t = $db->get_one("SELECT price FROM ".TABLE_PRODUCT." where productid=".$r['productid']." limit 0,1");
		$r['price'] = $t['price'];
		$r['pdt_amount'] = sprintf('%.2f',$r['price']*$r['pdt_number']);
		$r['pdt_name'] = str_cut($r['pdt_name'],50,'..');
		$pdt_carts[] = $r;
		
		$total_mount+= $r['pdt_amount'];
	}	
	$discount = isset($discount) ? $discount : 1;
	$member_mount = $total_mount*$discount;
	include template($mod,'showorder');
	exit();
}
?>