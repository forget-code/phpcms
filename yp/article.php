<?php
require './include/common.inc.php';
if(isset($catid))
{
	$tradeid = intval($catid);
	require_once PHPCMS_ROOT.'/include/tree.class.php';
	$tree = new tree;
	$TRADE = cache_read('trades_article.php');
	require_once MOD_ROOT.'/include/trade.func.php';
	$article_selected = trade_select('articlecatid',$LANG['select_category'],0);
	$ARE = cache_read('trade_'.$tradeid.'.php');
	@extract($ARE);
	$tradepos = tradepos($tradeid, ' &gt;&gt; ');
	$head['title'] = $tradename.'-'.$head['title'];
	if($child==1)
	{
		$arrchild = subtrade('article', $tradeid);
		$templateid = $templateid ? $templateid : 'article_list' ;
	}
	else
	{	
		$page = isset($page) ? intval($page) : 1;
		$templateid = $listtemplateid ? $listtemplateid : 'article_list';
	}
	include template($mod,$templateid);

}
else
{
	$lastedittime = @filemtime('article.html');
	$lastedittime = $PHP_TIME-$lastedittime;
	$autoupdatetime = intval($MOD['autoupdate']);
	if(file_exists('article.html') && $lastedittime<$autoupdatetime)
	{	
		include 'article.html';
	}
	else
	{
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;
		$TRADE = cache_read('trades_article.php');
		require_once MOD_ROOT.'/include/trade.func.php';
		$article_selected = trade_select('articlecatid',$LANG['select_category'],0);
		$head['title'] = $LANG['news'].$head['title'];
		ob_start();
		include template($mod, 'article');
		$data .= ob_get_contents();
		ob_clean();
		file_put_contents('article.html', $data);
		@chmod('article.html', 0777);	
		echo $data;
	}
}
?>
