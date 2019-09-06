<?php 
require './include/common.inc.php';
require_once 'form.class.php';

if($verify != md5(AUTH_KEY.$goodsid.$goodsname.$goodsurl.$unit.$price.$carriage.$stock)) showmessage('非法参数！');
require_once MOD_ROOT.'include/deliver.class.php';
$deliver = new deliver();
if(!$forward) $forward = HTTP_REFERER;

switch($action)
{
    case 'add':
		checkcode($checkcodestr, 1);
		if(!is_array($d)) showmessage('收货地址信息不能为空！');
		if($isnewdeliver) $deliver->add($d);
		$data = array('goodsid'=>$goodsid, 'goodsname'=>$goodsname, 'goodsurl'=>$goodsurl, 'unit'=>$unit, 'price'=>$price, 'number'=>$number, 'carriage'=>$carriage, 'consignee'=>$d['consignee'], 'areaid'=>$d['areaid'], 'telephone'=>$d['telephone'], 'mobile'=>$d['mobile'], 'address'=>$d['address'], 'postcode'=>$d['postcode'], 'note'=>$note);
		$orderid = $order->add($data);
		if(!$orderid) showmessage('参数错误', $forward);
		$forward = $M['url'].'index.php?action=pay&orderid='.$orderid;
		if($orderid) showmessage('下单成功，开始付款...', $forward);
		break;

	case 'confirm':
		$amount = $number*$price + $carriage;
		$head['title'] = '确认订单_'.$M['name'].'_'.$PHPCMS['sitename'];
		include template($mod, 'order_confirm');
		break;

    default :
		$delivers = $deliver->listinfo($_userid);
		if(!$delivers)
		{
			$member_api = load('member_api.class.php', 'member', 'api');
			$memberinfo = $member_api->get_model_info($_userid);
			if($memberinfo) extract($memberinfo);
		}
		if($_areaid) $areaid = $_areaid;

		$head['title'] = '在线下单_'.$M['name'].'_'.$PHPCMS['sitename'];
		$forward = $M['url'];

		include template($mod, 'order');
}
?>