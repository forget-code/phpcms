<?php
defined('IN_PHPCMS') or exit('Access Denied');
//error_reporting(E_ALL);

$script or showmessage($LANG['illegal_parameters']);

require_once PHPCMS_ROOT.'/include/tree.class.php';

require_once MOD_ROOT.'/include/trade.class.php';
require_once MOD_ROOT.'/include/trade.func.php';
unset($urlrule);
include MOD_ROOT.'/include/urlrule.inc.php';

$TRADE = cache_read('trades_'.$script.'.php');

$tradeid = isset($tradeid) ? intval($tradeid) : 0;
$module = $mod;

$tree = new tree;
$are = new trade($script, $tradeid);
$forward = '?mod='.$mod.'&file=trade&action=manage&script='.$script;

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file='.$file.'&action=manage&script='.$script),
	array($LANG['add_trade'], '?mod='.$mod.'&file='.$file.'&action=add&script='.$script),
	array($LANG['update_trade_cache'], '?mod='.$mod.'&file='.$file.'&action=updatecache&script='.$script),
	array($LANG['trade_data_repair'], '?mod='.$mod.'&file='.$file.'&action=repair&script='.$script),
);

$menu = adminmenu($LANG["script_$script"].$LANG['trade_manage'],$submenu);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':

		if($dosubmit)
		{
		    if(!$trade['tradename']) showmessage($LANG['trade_name_not_null']);
			$tradename = explode("\n", trim($trade['tradename']));
			foreach($tradename as $tradename)
			{
				$tradename = trim($tradename);
				if(!$tradename) continue;
				$trade['tradename'] = $tradename;
				$are->add($trade, $setting);
			}
	        showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&script='.$script.'&forward='.urlencode($forward));
		}
		else
	    {
			$parentid = trade_select('trade[parentid]',$LANG['no_as_top_trade'],$tradeid);
            $templateid = showtpl($module,$script,'setting[templateid]');
            $listtemplateid = showtpl($module,$script.'_list','setting[listtemplateid]');
		    $skinid = showskin('setting[skinid]', $script);
            $defaultitemtemplate = showtpl($module,'content','setting[defaultitemtemplate]');
		    $defaultitemskin = showskin('setting[defaultitemskin]', $script);
			$trade_urlrule = trade_urlrule_select('trade[urlruleid]','php',$script,0);
		    include admintpl('trade_add');
		}
		break;

	case 'edit':
		$tradeid = intval($tradeid);
		if(!$tradeid) showmessage($LANG['illegal_parameters']);

		if($dosubmit)
		{
		    if(!$trade['tradename']) showmessage($LANG['trade_name_not_null']);
            $are->edit($trade, $setting);

			showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&script='.$script.'&forward='.urlencode($forward));
		}
		else
	    {
			$trade = $are->get_info();
			unset($trade['script']);
            @extract(new_htmlspecialchars($trade));
			$oldparentid = $parentid;
			$parentid = trade_select('trade[parentid]',$LANG['no_as_top_trade'],$parentid);
		    $skinid = showskin('setting[skinid]',$skinid);
            $templateid = showtpl($module,'trade','setting[templateid]',$templateid);
            $listtemplateid = showtpl($module,'trade_list','setting[listtemplateid]',$listtemplateid);
			$trade_urlrule = trade_urlrule_select('trade[urlruleid]','php','trade',$urlruleid);
		    include admintpl('trade_edit');
		}
		break;

     case 'repair':
        $are->repair();
        showmessage($LANG['operation_success'], $forward);
		break;

     case 'delete':
		
		 $tradeid = intval($tradeid);
		 $r = $db->get_one("select * from ".TABLE_YP_TRADE." where tradeid=$tradeid");
		 if(!$r) showmessage($LANG['illegal_parameters'], $forward);

         $are->delete(0);
		 showmessage($LANG['operation_success'], $forward);
		 break;

    case 'listorder':
		$are->listorder($listorder);
		showmessage($LANG['operation_success'], $forward);
        break;

	case 'updatecache':
		$tradeids = cache_trades($script);
	    foreach($tradeids as $tradeid)
	    {
            $are->update_linkurl($tradeid);
		    cache_trade($tradeid);
	    }
        $are->repair();
		showmessage($LANG['trade_cache_update_success'], $forward);
		break;

	case 'manage':

		$list = $are->get_list();

		if(is_array($list))
	    {
			$trades = array();
			foreach($list as $tradeid => $trade)
			{
				$module = $mod;
				$linkurl = $trade['linkurl'];

				$trades[$trade['tradeid']] = array('id'=>$trade['tradeid'],'parentid'=>$trade['parentid'],'name'=>$trade['tradename'],'linkurl'=>$linkurl,'listorder'=>$trade['listorder'],'style'=>$trade['style'],'mod'=>$mod,'file'=>$file,'script'=>$script);
			}
			
			$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
						<td><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
						<td>\$id</td>
						<td align='left'>\$spacer<a href='\$linkurl' target='_blank'><span style='\$style'>\$name</span></a></td>
						<td><a href='?mod=\$mod&file=\$file&action=add&tradeid=\$id&script=\$script'>".$LANG['add_child_trade']."</a> | <a href='?mod=\$mod&file=\$file&action=edit&tradeid=\$id&parentid=\$parentid&script=\$script'>".$LANG['edit']."</a> | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&tradeid=\$id&script=\$script','".$LANG['confirm_delete_trade']."')>".$LANG['delete']."</a></td></tr>";
			$tree->tree($trades);
			$trades = $tree->get_tree(0,$str);
		}
		include admintpl('trade');
		$tradeids = cache_trades($script);
	    foreach($tradeids as $tradeid)
	    {
            $are->update_linkurl($tradeid);
		    cache_trade($tradeid);
	    }
		break;
}
?>