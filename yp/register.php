<?php
require './include/common.inc.php';

require PHPCMS_ROOT.'/include/formselect.func.php';
$action = isset($action) ? $action : '';
if(!$_userid)
{
	$register_member = $PHPCMS['siteurl'].'member/'."register.php?action=register&forward=".$PHP_URL;
	header("Location: $register_member");
}
else
{
	if($dosubmit)
	{
		if($MOD['ischeck'])
		{
			$status = 1;
		}
		else
		{
			$status = 3;
		}
		if(empty($pattern)) showmessage($LANG['choose_manages_pattern'],'goback');
		
		$companyname = new_htmlspecialchars($companyname);
		$product = new_htmlspecialchars($product);
		$tradeid = intval($tradeid);
		$patternString = '';
		foreach($pattern AS $v)
		{
			$patternString .= $v.'|';
		}
		$patternString = substr($patternString,0,-1);
		$regtime = strtotime($regtime);
		
		if(!$MOD['enableSecondDomain'])
		{
			$sitedomainkey = '';
			$sitedomain = '';
		}
		else
		{
			$__sitedomain = $sitedomain;
			$sitedomainkey = '`sitedomain` , ';
			$sitedomain = "'$sitedomain', ";
		}
		$result = $db->query("INSERT INTO ".TABLE_MEMBER_COMPANY." (`companyname` , `username` , `pattern` , `areaid`, `tradeid`, `typeid` , `product` , `regtime` , `employnum` , `turnover` , `status` , $sitedomainkey `addtime`) VALUES ('$companyname' , '$_username' , '$patternString' , '$areaid', '$tradeid', '$typeid' , '$product' , '$regtime' , '$employnum' , '$turnover' , '$status' , $sitedomain '$PHP_TIME')");
		$companyid = $db->insert_id();
		if($MOD['enableSecondDomain'])
		{
			$INDEX = $linkurl = 'http://'.$__sitedomain.'.'.$MOD['secondDomain'];
		}
		else
		{
			if(!preg_match("/http:\/\//",$MOD['linkurl']))
			{
				$MOD['linkurl'] = $PHPCMS['siteurl'].'yp';
			}
			$linkurl = $MOD['linkurl']."/web/?".$_userid;
			$INDEX = $MOD['linkurl']."/?".$_userid;
		}
		$system[0]['menutitle'] = $LANG['site_domain'];
		$system[1]['menutitle'] = $LANG['introduce'];
		$system[2]['menutitle'] = $LANG['label_article'];
		$system[3]['menutitle'] = $LANG['label_product'];
		$system[4]['menutitle'] = $LANG['buy_product_info'];
		$system[5]['menutitle'] = $LANG['stats_product'];
		$system[6]['menutitle'] = $LANG['job'];
		$system[7]['menutitle'] = $LANG['contact'];
		$system[0]['url'] = $INDEX;
		$system[1]['url'] = $linkurl.'/categroy-introduce.html';
		$system[2]['url'] = $linkurl.'/categroy-article.html';
		$system[3]['url'] = $linkurl.'/categroy-product.html';
		$system[4]['url'] = $linkurl.'/categroy-buy.html';
		$system[5]['url'] = $linkurl.'/categroy-sales.html';
		$system[6]['url'] = $linkurl.'/categroy-job.html';
		$system[7]['url'] = $linkurl.'/categroy-introduce.html#contact';
		$menusetting['system'] = $system;
		$menusetting = addslashes(serialize(new_stripslashes($menusetting)));
		$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET menu='$menusetting',linkurl='$INDEX' WHERE companyid=$companyid");
		showmessage($LANG['Rregisters_successfully'],$PHPCMS['siteurl'].'yp/admin.php','3000');
	}
	elseif($action == 'checkdomain')
	{
		$result = $db->get_one("SELECT username FROM ".TABLE_MEMBER_COMPANY." WHERE sitedomain = '$domain'");
		if(!preg_match("/^[a-z0-9-]+$/i",$domain))
		{
			echo 1;
		}
		elseif($result)
		{
			echo 2;
		}
		else
		{
			echo 0;
		}
	}
	else
	{
		$result = $db->get_one("SELECT username FROM ".TABLE_MEMBER_COMPANY." WHERE username = '$_username'");
		if($result) showmessage($LANG['already_registered']);

		$patterns = $pattern = '';
		$patterns = explode('|',$MOD['pattern']);
		foreach($patterns AS $p)
		{
			$pattern .= '<input name="pattern[]" type="checkbox" value="'.$p.'"> '.$p;
		}
		$type_selected = "<select name='typeid' ><option value='0'>".$LANG['please_choose_company_type']."</option>";
		$types = explode("\n",$MOD['type']);
		foreach($types AS $t)
		{
			$type_selected .= "<option value='$t'>$t</option>";
		}
		$type_selected .= "</select>";
		
		$fromdate = '2006-10-1';
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;
		$AREA = cache_read('areas_'.$mod.'.php');
		require_once PHPCMS_ROOT.'/include/area.func.php';
		$TRADE = cache_read('trades_trade.php');
		require_once MOD_ROOT.'/include/trade.func.php';
		include template('yp', 'register');
	}
}
?>