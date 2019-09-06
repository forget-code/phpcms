<?php
defined('IN_PHPCMS') or exit('Access Denied');
$keyid or showmessage($LANG['illegal_parameters']);

require_once PHPCMS_ROOT.'/include/tree.class.php';

require_once PHPCMS_ROOT.'/include/area.class.php';
require_once PHPCMS_ROOT.'/include/area.func.php';
unset($urlrule);
include PHPCMS_ROOT.'/include/urlrule.inc.php';

$AREA = cache_read('areas_'.$keyid.'.php');

$areaid = isset($areaid) ? intval($areaid) : 0;
$module = $mod;

$tree = new tree;
$are = new area($keyid, $areaid);
$forward = '?mod=phpcms&file=area&action=manage&keyid='.$keyid;

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file='.$file.'&action=manage&keyid='.$keyid),
	array($LANG['add_area'], '?mod='.$mod.'&file='.$file.'&action=add&keyid='.$keyid),
	array($LANG['update_area_cache'], '?mod='.$mod.'&file='.$file.'&action=updatecache&keyid='.$keyid),
	array($LANG['area_data_repair'], '?mod='.$mod.'&file='.$file.'&action=repair&keyid='.$keyid),
	array($LANG['import_area'], '?mod='.$mod.'&file='.$file.'&action=import&keyid='.$keyid),
	array($LANG['share_area'], '?mod='.$mod.'&file='.$file.'&action=copy&keyid='.$keyid),
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
	        showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&keyid='.$keyid.'&forward='.urlencode($forward));
		}
		else
	    {
			$parentid = area_select('area[parentid]',$LANG['no_as_top_area'],$areaid);
            $templateid = showtpl($module,'area','setting[templateid]');
            $listtemplateid = showtpl($module,'area_list','setting[listtemplateid]');
		    $skinid = showskin('setting[skinid]', $keyid);
            $defaultitemtemplate = showtpl($module,'content','setting[defaultitemtemplate]');
		    $defaultitemskin = showskin('setting[defaultitemskin]', $keyid);
			$area_urlrule = area_urlrule_select('area[urlruleid]','php','area',0);
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

			showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&keyid='.$keyid.'&forward='.urlencode($forward));
		}
		else
	    {
			$area = $are->get_info();
			unset($area['keyid']);
            @extract(new_htmlspecialchars($area));
			$oldparentid = $parentid;
			$parentid = area_select('area[parentid]',$LANG['no_as_top_area'],$parentid);
		    $skinid = showskin('setting[skinid]',$skinid);
            $templateid = showtpl($module,'area','setting[templateid]',$templateid);
            $listtemplateid = showtpl($module,'area_list','setting[listtemplateid]',$listtemplateid);
			$area_urlrule = area_urlrule_select('area[urlruleid]','php','area',$urlruleid);
		    include admintpl('area_edit');
		}
		break;

     case 'repair':
        $are->repair();
        showmessage($LANG['operation_success'], $forward);
		break;

     case 'delete':
		 $areaid = intval($areaid);
		 $r = $db->get_one("select * from ".TABLE_AREA." where areaid=$areaid");
		 if(!$r) showmessage($LANG['illegal_parameters'], $forward);

         $are->delete(0);
		 showmessage($LANG['operation_success'], $forward);
		 break;

    case 'listorder':
		$are->listorder($listorder);
		showmessage($LANG['operation_success'], $forward);
        break;

	case 'updatecache':
		$areaids = cache_areas($keyid);
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
			  'keyid' => $keyid,
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
					$are->areaid = $areas['parentid'] = get_area_id($keyid, $provinces[$pid]);
					$result = $db->query("select city from ".TABLE_CITY." where province='$provinces[$pid]' ");
					while($r = $db->fetch_array($result))
					{
						if(get_area_id($keyid, $r['city'])) continue;
						$areas['areaname'] = $r['city'];
						$are->add($areas, $settings);
					}
				}

			}
			showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=updatecache&keyid=$keyid");
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
		if(isset($request_keyid))// For Ajax
		{
			$AREA = cache_read("areas_".$request_keyid.".php");
			echo str_replace("<select name='areaid' ><option value='0'></option>", '<select name="targetareaid" size="2" style="height:300px;width:350px;"><option value="0" selected>新建地区</option>', area_select('areaid'));
			exit;
		}
		if($dosubmit)
		{
			if(!$batchareaid) showmessage($LANG['select_area']);
			if(!$tokeyid) showmessage($LANG['select_cha']);
			$batchareaname = array();
			foreach($batchareaid as $bid)
			{
				$batchareaname[] = $AREA[$bid]['areaname'];
			}
			$CHA = cache_read('channel_'.$tokeyid.'.php');
			$AREA = cache_read('areas_'.$tokeyid.'.php');
			$neware = new area_channel($tokeyid, $targetareaid);
			$areas = array (
			  'keyid' => $tokeyid,
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
			showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=updatecache&keyid=$tokeyid");
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

				$areas[$area['areaid']] = array('id'=>$area['areaid'],'parentid'=>$area['parentid'],'name'=>$area['areaname'],'linkurl'=>$linkurl,'listorder'=>$area['listorder'],'style'=>$area['style'],'mod'=>$mod,'file'=>$file,'keyid'=>$keyid);
			}
			
			$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
						<td><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
						<td>\$id</td>
						<td align='left'>\$spacer<a href='\$linkurl' target='_blank'><span style='\$style'>\$name</span></a></td>
						<td><a href='?mod=\$mod&file=\$file&action=add&areaid=\$id&keyid=\$keyid'>".$LANG['add_child_area']."</a> | <a href='?mod=\$mod&file=\$file&action=edit&areaid=\$id&parentid=\$parentid&keyid=\$keyid'>".$LANG['edit']."</a> | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&areaid=\$id&keyid=\$keyid','".$LANG['confirm_delete_area']."')>".$LANG['delete']."</a></td></tr>";
			$tree->tree($areas);
			$areas = $tree->get_tree(0,$str);
		}
		include admintpl('area');
		$areaids = cache_areas($keyid);
	    foreach($areaids as $areaid)
	    {
            $are->update_linkurl($areaid);
		    cache_area($areaid);
	    }
		break;
}
?>