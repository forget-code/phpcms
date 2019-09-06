<?php
require './include/common.inc.php';
$action = isset($action) ? $action : '';
$patterns = explode('|',$MOD['pattern']);
$pattern = '';
foreach($patterns AS $patt)
{
	$pattern .= " <a href='$MOD[linkurl]company.php?action=pattern&item=".$patt."'>".$patt."</a> ";
}
$trades = explode("\n",$MOD['comtype']);
switch($action)
{
	case 'pattern':
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;
		$AREA = cache_read('areas_'.$mod.'.php');
		require_once PHPCMS_ROOT.'/include/area.func.php';
		$TRADE = cache_read('trades_trade.php');
		require_once MOD_ROOT.'/include/trade.func.php';
		include template($mod,'company_pattern');
	break;
	default :
		$lastedittime = @filemtime('company.html');
		$lastedittime = $PHP_TIME-$lastedittime;
		$autoupdatetime = intval($MOD['autoupdate']);
		if(file_exists('company.html') && $lastedittime<$autoupdatetime)
		{	
			include 'company.html';
		}
		else
		{
			require_once PHPCMS_ROOT.'/include/tree.class.php';
			$tree = new tree;
			$AREA = cache_read('areas_'.$mod.'.php');
			require_once PHPCMS_ROOT.'/include/area.func.php';
			$TRADE = cache_read('trades_trade.php');
			require_once MOD_ROOT.'/include/trade.func.php';		
			$head['title'] = $LANG['company'].$head['title'];
			ob_start();
			include template($mod, 'company');
			$data .= ob_get_contents();
			ob_clean();
			file_put_contents('company.html', $data);
			@chmod('company.html', 0777);	
			echo $data;
		}
	break;
}
?>
