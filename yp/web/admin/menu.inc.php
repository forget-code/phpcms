<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($action == 'createindex')
{
	createhtml('header',PHPCMS_ROOT.'/yp/web');
	createhtml('index',PHPCMS_ROOT.'/yp/web');
	createhtml('introduce',PHPCMS_ROOT.'/yp/web');
	showmessage($LANG['update_index_introduce_success'],"?file=menu");
}
if($dosubmit)
{
	$menusetting = array();
	foreach($systemmenu AS $k=>$v)
	{
		$menusetting['system'][$k]['menutitle'] = $v;
		switch($v)
		{
			case $LANG['site_domain']:
				$menusetting['system'][$k]['url'] = $INDEX;
			break;
			case $LANG['introduce']:
				$menusetting['system'][$k]['url'] = $introduceurl;
			break;
			case $LANG['label_article']:
				$menusetting['system'][$k]['url'] = $articleurl;
			break;
			case $LANG['product']:
				$menusetting['system'][$k]['url'] = $producturl;
			break;
			case $LANG['buy_product_info']:
				$menusetting['system'][$k]['url'] = $buyurl;
			break;
			case $LANG['stats_product']:
				$menusetting['system'][$k]['url'] = $salesurl;
			break;
			case $LANG['job']:
				$menusetting['system'][$k]['url'] = $joburl;
			break;
			case $LANG['contact']:
				$menusetting['system'][$k]['url'] = $introduceurl."#contact";
			break;
		}	
	}
	if($usermenu!='')
	{
		$usermenu = explode("\n",$usermenu);
		foreach($usermenu AS $k=>$v)
		{
			$v_s = explode('|',$v);
			$menutitle = $v_s[0];
			$menuurl = $v_s[1];

			$menusetting['user'][$k]['menutitle'] = $menutitle;
			$menusetting['user'][$k]['url'] = $menuurl;
		}
	}
	$menusetting = addslashes(serialize(new_stripslashes($menusetting)));
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET menu = '$menusetting' WHERE username='$_username'");
	$forward = "?file=menu&action=createindex";
	showmessage($LANG['operation_success'],$forward);
}
else
{
	require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$mod.'/companytplnames.php';
	$menuarray = array($LANG['site_domain'],$LANG['introduce'],$LANG['label_article'],$LANG['product'],$LANG['buy_product_info'],$LANG['stats_product'],$LANG['job'],$LANG['contact']);
	$menus = '';
	foreach($menuarray AS $v)
	{
		$checked = '';
		foreach($m_system AS $k=>$m_s)
		{
			if($v==$m_system[$k]['menutitle']) $checked = 'checked';
		}		
		$menus .= "<input type='checkbox' name='systemmenu[]' value='$v' $checked>$v ";
	}
	$usermenu = '';
	foreach($m_user AS $v)
	{
		$usermenu .= $v['menutitle'].'|'.$v['url']."\n";
	}
	$usermenu = substr($usermenu,0,-1);
	include managetpl('menu');
}
?>