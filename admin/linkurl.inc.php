<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($channelid)
{
	require PHPCMS_ROOT.'/include/channel.inc.php';
	$module = $CHANNEL[$channelid]['module'];
	$table = channel_table($module, $channelid);
}
elseif($module)
{
	require PHPCMS_ROOT.'/include/module.func.php';
	require PHPCMS_ROOT.'/'.$module.'/include/urlrule.inc.php';
	$mod = $module;
	$table = $CONFIG['tablepre'].$module;
	$MOD = cache_read($module.'_setting.php');
	$CATEGORY = cache_read('categorys_'.$module.'.php');
}

switch($action)
{
    case 'updatechannel':

		header('location:?mod=phpcms&file='.$file.'&action=updatecategory&updatechannel=1&channelid='.$channelid);
		
		break;

    case 'updatemodule':

		header('location:?mod=phpcms&file='.$file.'&action=updatecategory&updatemodule=1&module='.$module);
		
		break;

	case 'updatecategory':
		if($channelid)
		{
			require_once PHPCMS_ROOT.'/admin/include/category_channel.class.php';
			$cat = new category_channel($channelid);
		}
		else
	    {
			require_once PHPCMS_ROOT.'/admin/include/category_module.class.php';
			$cat = new category_module($module);
		}
		$catids = (isset($catid) && $catid) ? explode(',', $CATEGORY[$catid]['arrchildid']) : array_keys($CATEGORY);
		foreach($catids as $id)
		{
            $cat->update_linkurl($id);
		}
		if($updatechannel)
	    {
		    $forward =  '?mod=phpcms&file='.$file.'&action=updatespecial&updatechannel=1&channelid='.$channelid;
		}
		elseif($updatemodule)
	    {
		    $forward =  '?mod=phpcms&file='.$file.'&action=updateitem&updatemodule=1&module='.$module.'&catid='.$catid;
		}
		elseif($updatecategory)
	    {
			if($channelid)
			{
				$p = '&updatechannel=1&channelid='.$channelid;
			}
			else
			{
				$p = '&updatemodule=1&module='.$module;
			}
		    $forward =  '?mod=phpcms&file='.$file.'&action=updateitem'.$p.'&catid='.$catid;
		}
		else
	    {
			$forward = '';
		}
		showmessage($LANG['category_urls_has_updated'], $forward);

		break;

	case 'updatespecial':

		require PHPCMS_ROOT.'/admin/include/special.class.php';
		$spe = new special($channelid);
		$spe->update_linkurl();
		if($updatechannel)
	    {
		    $forward = '?mod=phpcms&file='.$file.'&action=updateitem&updatechannel=1&channelid='.$channelid;
		}
		elseif($updatemodule)
	    {
		    $forward = '?mod=phpcms&file='.$file.'&action=updateitem&updatemodule=1&module='.$module;
		}
		else
	    {
			$forward = '';
		}
		showmessage($LANG['special_urls_has_updated'], $forward);

		break;

	case 'updateitem':

		$sql = (isset($catid) && $catid) ? " WHERE catid IN(".$CATEGORY[$catid]['arrchildid'].") " : '';
		$pernumber = isset($pernumber) ? $pernumber : 1000;
		$page = isset($page) ? intval($page) : 1;
		$offset = $page ? ($page-1)*$pernumber : 0;

		if($page == 1)
		{
			$n = $db->get_one("SELECT COUNT(*) AS number FROM $table $sql");
			$number = $n['number'];
		}

		$idfield = $module.'id';
		$result = $db->query("SELECT * FROM $table $sql ORDER BY $idfield LIMIT $offset,$pernumber");
		while($r = $db->fetch_array($result))
		{
			if(isset($r['islink']) && $r['islink']) continue;
			extract($r, EXTR_OVERWRITE);
			$itemid = ${$idfield};
			$linkurl = item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, 0);
			$db->query("UPDATE $table SET linkurl='$linkurl' where $idfield=$itemid");
		}
		$donumber = $db->num_rows($result);
		$startnumber = $offset+$pernumber;
		if($startnumber < $number)
		{
			$message = $CHA['channelname'].$LANG['from'].($offset+1).$LANG['to'].($offset+$donumber).$LANG['urls_has_updated'];
			if($updatechannel)
			{
				$p = '&updatechannel=1&channelid='.$channelid;
			}
			elseif($updatemodule)
			{
				$p = '&updatemodule=1&module='.$module;
			}
			$forward = '?mod=phpcms&file='.$file.'&action='.$action.$p.'&number='.$number.'&page='.($page+1);
		}
		else
		{
			if($updatechannel)
			{
				$message = $CHA['channelname'].$LANG['channel_urls_has_updated'];
			}
			elseif($updatemodule)
			{
				$message = $MOD['name'].$LANG['module_urls_has_updated'];
			}
			$forward = '';
		}
		showmessage($message, $forward);

		break;
}
?>