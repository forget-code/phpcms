<?php 

include_once './include/common.inc.php';
$action = isset($action) ? $action : 'manage';
$actionarray = array('add','edit','delete','manage','modifynum');
in_array($action,$actionarray) or showmessage($LANG['illegal_action'],$referer);

if(!$_userid)
{
	showmessage($LANG['login_website'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
}

$head['title'] = $_username.$LANG['someone_cart'];
$head['keywords'] = $_username.$LANG['someone_cart'];
$head['description'] = $_username.$LANG['someone_cart'];

switch ($action)
{
	case 'add':
		$productid = intval($productid);
		$productid  or showmessage($LANG['illegal_operation']);
		//check the cart y/n? have this product
		$query = "SELECT productid FROM ".TABLE_PRODUCT_CART." WHERE user_id=$_userid AND productid=$productid AND odr_id=0 limit 0,1" ;
		$r = $db->get_one($query);
		if($r)
		{
			showmessage($LANG['existing_product_modify_num'],$MOD['linkurl'].'cart.php');
		}
		$query = "SELECT pdt_name,pdt_No From ".TABLE_PRODUCT." WHERE productid=".$productid." limit 0,1";
		$r = $db->get_one($query);
		$query = "INSERT INTO ".TABLE_PRODUCT_CART."(odr_id,user_id,productid,pdt_No,pdt_name,pdt_number)"
				." VALUES(0,$_userid,$productid,'".$r['pdt_No']."','".$r['pdt_name']."',1)";
		$db->query($query);
		showmessage($LANG['operation_success'],'cart.php');
	case 'delete':
		$productid = intval($productid);
		$productid  or showmessage($LANG['illegal_operation']);
		$db->query('Delete From '.TABLE_PRODUCT_CART." WHERE  user_id=$_userid  and productid=$productid");
		showmessage($LANG['operation_success'],$MOD['linkurl'].'cart.php');
	case 'manage':
		$pagesize= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 10;
		$page = isset($page) ? $page : 1;
		$offset = $page ? ($page-1)*$pagesize : 0;
		
		$r = $db->get_one("select count(*) as num from ".TABLE_PRODUCT_CART." where user_id=$_userid AND odr_id=0");
		$number=$r["num"];
		if($number == 0)
		{
			showmessage($LANG['no_product'],$MOD['linkurl']);
		}
		$pages = phppages($number,$page,$pagesize);
		$total_mount = 0;
		$pdt_carts = array();
		$result=$db->query("SELECT cart.cart_id, cart.odr_id, cart.user_id, cart.productid, cart.pdt_No, cart.pdt_number,p.productid, p.pdt_name, p.price, p.marketprice,p.linkurl".
							" FROM ".TABLE_PRODUCT_CART." cart,".TABLE_PRODUCT." p where user_id=$_userid  AND odr_id=0 AND cart.productid=p.productid order by cart_id desc limit $offset,$pagesize");
		
		while($r=$db->fetch_array($result))
		{
			$r['pdt_amount'] = sprintf('%.2f',$r['price']*$r['pdt_number']);
			$r['member_price'] = sprintf('%.2f',$r['price']*$discount);
			$r['pdt_name'] = str_cut($r['pdt_name'],50,'..');
			$r['linkurl'] = linkurl($r['linkurl']);
			$pdt_carts[] = $r;
			$total_mount+= $r['pdt_amount'];
		}
		$total_mount = sprintf('%.2f',$total_mount);
		$member_mount = sprintf('%.2f',$total_mount*$discount);
		include template($mod,'cart');
		break;
		
	case 'modifynum':
		if(is_array($pdt_number))
		{
			foreach ($pdt_number as $k => $number)
			{
				if(!is_numeric($number[0]) || intval($number[0])<=0)
				{
					showmessage($LANG['product_illegal_char']);
				}
			}
		}
		else showmessage($LANG['illegal_request_return'],$MOD['linkurl'].'cart.php');
		
		foreach ($pdt_number as $k => $number)
		{
			$query = "UPDATE ".TABLE_PRODUCT_CART." SET pdt_number=".intval($number[0])." WHERE cart_id=".$k;
			$db->query($query);
		}
		showmessage($LANG['product_num_modified'],$MOD['linkurl'].'cart.php');
}

?>