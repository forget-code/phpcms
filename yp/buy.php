<?php
require './include/common.inc.php';
if(isset($catid))
{
	$tradeid = intval($catid);
	require_once PHPCMS_ROOT.'/include/tree.class.php';
	$tree = new tree;
	$AREA = cache_read('areas_'.$mod.'.php');
	require_once PHPCMS_ROOT.'/include/area.func.php';
	$TRADE = cache_read('trades_buy.php');
	require_once MOD_ROOT.'/include/trade.func.php';
	$ARE = cache_read('trade_'.$tradeid.'.php');
	@extract($ARE);
	$tradepos = tradepos($tradeid, ' &gt;&gt; ');
	$head['title'] = $tradename.'-'.$head['title'];
	if($child==1)
	{
		$arrchild = subtrade('buy', $tradeid);
		$templateid = $templateid ? $templateid : 'buy_list' ;
	}
	else
	{	
		$page = isset($page) ? intval($page) : 1;
		$templateid = $listtemplateid ? $listtemplateid : 'buy_list';
	}
	include template($mod,$templateid);

}
else
{
	$lastedittime = @filemtime('buy.html');
	$lastedittime = $PHP_TIME-$lastedittime;
	$autoupdatetime = intval($MOD['autoupdate']);
	if(file_exists('buy.html') && $lastedittime<$autoupdatetime)
	{	
		include 'buy.html';
	}
	else
	{
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;
		$AREA = cache_read('areas_'.$mod.'.php');
		require_once PHPCMS_ROOT.'/include/area.func.php';
		require_once PHPCMS_ROOT.'/yp/include/trade.func.php';
		$TRADE = cache_read('trades_buy.php');
		$buy_selected = trade_select('tradeid',$LANG['select_category'],$tradeid);
		$head['title'] = $LANG['buy'].$head['title'];
		ob_start();
		include template($mod, 'buy');
		$data .= ob_get_contents();
		ob_clean();
		file_put_contents('buy.html', $data);
		@chmod('buy.html', 0777);	
		echo $data;
	}
}
?>
