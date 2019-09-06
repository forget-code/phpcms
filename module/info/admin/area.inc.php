<?php
defined('IN_PHPCMS') or exit('Access Denied');
$channelid = intval($channelid);
$channelid or showmessage($LANG['illegal_parameters']);

require_once PHPCMS_ROOT.'/include/tree.class.php';

require_once PHPCMS_ROOT.'/module/'.$mod.'/include/area.class.php';
require_once PHPCMS_ROOT.'/module/'.$mod.'/include/global.func.php';
unset($urlrule);
include PHPCMS_ROOT.'/module/'.$mod.'/include/urlrule.inc.php';

$AREA = cache_read('areas_'.$channelid.'.php');

$areaid = isset($areaid) ? intval($areaid) : 0;
$module = $mod;

$tree = new tree;
$are = new area_channel($channelid, $areaid);
$forward = '?mod=info&file=area&action=manage&channelid='.$channelid;

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid),
	array($LANG['add_area'], '?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid),
	array($LANG['update_area_cache'], '?mod='.$mod.'&file='.$file.'&action=updatecache&channelid='.$channelid),
	array($LANG['area_data_repair'], '?mod='.$mod.'&file='.$file.'&action=repair&channelid='.$channelid),
	array($LANG['import_area'], '?mod='.$mod.'&file='.$file.'&action=import&channelid='.$channelid),
	array($LANG['share_area'], '?mod='.$mod.'&file='.$file.'&action=copy&channelid='.$channelid),
);

$menu = adminmenu($LANG['area_manage'],$submenu);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':

		if($dosubmit)
		{
		    if(!$area['areaname']) showmessage($LANG['area_name_not_null']);
			$areaname = explode("\n", trim($area['areaname']));
			foreach($areaname as $areaname)
			{
				$areaname = trim($areaname);
				if(!$areaname) continue;
				$area['areaname'] = $areaname;
				$are->add($area, $setting);
			}
	        showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&channelid='.$channelid.'&forward='.urlencode($forward));
		}
		else
	    {
			$parentid = area_select('area[parentid]',$LANG['no_as_top_area'],$areaid);
            $templateid = showtpl($module,'area','setting[templateid]');
            $listtemplateid = showtpl($module,'area_list','setting[listtemplateid]');
		    $skinid = showskin('setting[skinid]','info');
            $defaultitemtemplate = showtpl($module,'content','setting[defaultitemtemplate]');
		    $defaultitemskin = showskin('setting[defaultitemskin]','info');
			$area_urlrule = info_urlrule_select('area[urlruleid]','php','area',0);
		    include admintpl('area_add');
		}
		break;

	case 'edit':
		$areaid = intval($areaid);
		if(!$areaid) showmessage($LANG['illegal_parameters']);

		if($dosubmit)
		{
		    if(!$area['areaname']) showmessage($LANG['area_name_not_null']);
            $are->edit($area, $setting);

			showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&channelid='.$channelid.'&forward='.urlencode($forward));
		}
		else
	    {
			$area = $are->get_info();
			unset($area['channelid']);
            @extract(new_htmlspecialchars($area));
			$oldparentid = $parentid;
			$parentid = area_select('area[parentid]',$LANG['no_as_top_area'],$parentid);
		    $skinid = showskin('setting[skinid]',$skinid);
            $templateid = showtpl($module,'area','setting[templateid]',$templateid);
            $listtemplateid = showtpl($module,'area_list','setting[listtemplateid]',$listtemplateid);
			$area_urlrule = info_urlrule_select('area[urlruleid]','php','area',$urlruleid);
		    include admintpl('area_edit');
		}
		break;

     case 'repair':
        $are->repair();
        showmessage($LANG['operation_success'], $forward);
		break;

     case 'delete':
		 $areaid = intval($areaid);
		 $r = $db->get_one("select * from ".TABLE_INFO_AREA." where areaid=$areaid");
		 if(!$r) showmessage($LANG['illegal_parameters'], $forward);

         $are->delete();
		 showmessage($LANG['operation_success'], $forward);
		 break;

    case 'listorder':
		$are->listorder($listorder);
		showmessage($LANG['operation_success'], $forward);
        break;

	case 'updatecache':
		$areaids = cache_areas($channelid);
	    foreach($areaids as $areaid)
	    {
            $are->update_linkurl($areaid);
		    cache_area($areaid);
	    }
        $are->repair();
		showmessage($LANG['area_cache_update_success'], $forward);
		break;

	case 'import':
		defined('TABLE_PROVINCE') or showmessage($LANG['no_area']);
		if($dosubmit)
		{
			$areas = array (
			  'channelid' => $channelid,
			  'parentid' => '0',
			  'areaname' => '',
			  'style' => '',
			  'urlruleid' => '0',
			);
			$settings = array (
			  'seo_title' => '',
			  'seo_keywords' => '',
			  'seo_description' => '',
			  'skinid' => '0',
			  'templateid' => '0',
			  'listtemplateid' => '0',
			);
			$parentid = 0;
		    foreach($province as $pid=>$v)
			{
				if($v)
				{
					$areas['parentid'] = 0;
					$areas['areaname'] = $provinces[$pid];
					$are->add($areas, $settings);
				}
				if($city[$pid])
				{
					$are->areaid = $areas['parentid'] = get_area_id($channelid, $provinces[$pid]);
					$result = $db->query("select city from ".TABLE_CITY." where province='$provinces[$pid]' ");
					while($r = $db->fetch_array($result))
					{
						if(get_area_id($channelid, $r['city'])) continue;
						$areas['areaname'] = $r['city'];
						$are->add($areas, $settings);
					}
				}

			}
			showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=updatecache&channelid=$channelid");
		}
		else
	    {
			$result = $db->query("select * from ".TABLE_PROVINCE);
			$provinces = array();
			while($r = $db->fetch_array($result))
			{
				$provinces[$r['provinceid']] = $r;
			}
			$provinces or showmessage($LANG['no_area']);
		    include admintpl('area_import');
		}
		break;

	case 'copy':
		if(isset($request_channelid))// For Ajax
		{
			$AREA = cache_read("areas_".$request_channelid.".php");
			echo str_replace("<select name='areaid' ><option value='0'></option>", '<select name="targetareaid" size="2" style="height:300px;width:350px;"><option value="0" selected>新建地区</option>', area_select('areaid'));
			exit;
		}
		if($dosubmit)
		{
			if(!$batchareaid) showmessage($LANG['select_area']);
			if(!$tochannelid) showmessage($LANG['select_cha']);
			$batchareaname = array();
			foreach($batchareaid as $bid)
			{
				$batchareaname[] = $AREA[$bid]['areaname'];
			}
			$CHA = cache_read('channel_'.$tochannelid.'.php');
			$AREA = cache_read('areas_'.$tochannelid.'.php');
			$neware = new area_channel($tochannelid, $targetareaid);
			$areas = array (
			  'channelid' => $tochannelid,
			  'parentid' => $targetareaid,
			  'areaname' => '',
			  'style' => '',
			  'urlruleid' => '0',
			);
			$settings = array (
			  'seo_title' => '',
			  'seo_keywords' => '',
			  'seo_description' => '',
			  'skinid' => '0',
			  'templateid' => '0',
			  'listtemplateid' => '0',
			);
			foreach($batchareaname as $bname)
			{
				$areas['areaname'] = $bname;
				$neware->add($areas, $settings);
			}
			showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=updatecache&channelid=$tochannelid");
		}
		else
		{
			$area_select = str_replace("<select name='areaid' ><option value='0'></option>", '', area_select('areaid'));
			include admintpl('area_copy');
		}
		break;
	case 'manage':

		$list = $are->get_list();

		if(is_array($list))
	    {
			$areas = array();
			foreach($list as $areaid => $area)
			{
				$module = $mod;
				$linkurl = $area['linkurl'];

				$areas[$area['areaid']] = array('id'=>$area['areaid'],'parentid'=>$area['parentid'],'name'=>$area['areaname'],'linkurl'=>$linkurl,'listorder'=>$area['listorder'],'style'=>$area['style'],'mod'=>$mod,'file'=>$file,'channelid'=>$channelid);
			}
			
			$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
						<td><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
						<td>\$id</td>
						<td align='left'>\$spacer<a href='\$linkurl' target='_blank'><span style='\$style'>\$name</span></a></td>
						<td><a href='?mod=\$mod&file=\$file&action=add&areaid=\$id&channelid=\$channelid'>".$LANG['add_child_area']."</a> | <a href='?mod=\$mod&file=\$file&action=edit&areaid=\$id&parentid=\$parentid&channelid=\$channelid'>".$LANG['edit']."</a> | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&areaid=\$id&channelid=\$channelid','".$LANG['confirm_delete_area']."')>".$LANG['delete']."</a></td></tr>";
			$tree->tree($areas);
			$areas = $tree->get_tree(0,$str);
		}
		include admintpl('area');
		$areaids = cache_areas($channelid);
	    foreach($areaids as $areaid)
	    {
            $are->update_linkurl($areaid);
		    cache_area($areaid);
	    }
		break;
}
?>