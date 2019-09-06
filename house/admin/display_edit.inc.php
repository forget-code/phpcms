<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($mod);

if(isset($submit))
{ 
	//检查浏览器输入
	if(empty($display['name']))
	{
		showmessage('楼盘名称不得为空','goback');
	}
	if(empty($display['develop']))
	{
		showmessage('开发商不得为空','goback');
	}
	if(empty($display['areaid']))
	{
		showmessage('所在区域不得为空','goback');
	}
	if(!isset($displayid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$displayid = intval($displayid);

	$display['edittime'] = $PHP_TIME;
	$display['urlruleid'] = $display['ishtml'] ? $html_urlrule : $php_urlrule;
	//生成URl规则
	
	if(isset($display['arrposid']))
	{
		$arrposid = $display['arrposid'];
		$display['arrposid'] = ','.implode(',', $arrposid).',';
	}
	else
	{
        $arrposid = array();
		$display['arrposid'] = '';
	}
	$display['linkurl'] = display_item_url('url', $display['ishtml'], $display['urlruleid'], $display['htmldir'], $display['prefix'], $displayid, $display['addtime']);

	//更新SQL
	$sql = $s = '';
	foreach($display as $key=>$value)
	{
		$sql .= $s.$key."='".$value."'";
		$s = ',';
	}
	$db->query("UPDATE ".TABLE_HOUSE_DISPLAY." SET $sql WHERE displayid=$displayid");
	
	//生成html
	if($MOD['ishtml']) createhtml('index');
	if($MOD['displayishtml']) createhtml('newhouse');
	if($MOD['createlistdisplay']) createhtml("listdisplay");
	
	$db->query("DELETE FROM ".TABLE_HOUSE_HOLD." WHERE displayid=$displayid");
	//插入房型图表house_hold
	foreach($householdimage_url as $k=>$v)
	{
		if($v)
		{
			$thumb = '';
			if(strpos($v,'http')===false)
			{
				$thumb = str_replace(basename($v),'thumb_'.basename($v),$v);
			}
			$db->query("INSERT INTO ".TABLE_HOUSE_HOLD." (title,thumb,image,area,displayid) VALUES('".$householdimage_title[$k]."','$thumb','$v','".$householdimage_area[$k]."','$displayid')");
		}		
	}	
	if(isset($arrposid) || isset($old_arrposid))
	{
		$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
		$pos->edit($displayid, $old_posid_arr, $display['arrposid']);
	}
	showmessage($LANG['operation_success'],"?mod=$mod&file=display&action=manage");	
	
}
else
{
	require_once PHPCMS_ROOT."/$mod/include/formselect.func.php";
	$TYPE = cache_read('type_house.php');
	
	$displayid = isset($displayid) ? intval($displayid) : 0;
	if(!$displayid)
	{
		showmessage($LANG['illegal_parameters'],$referer);
	}
	$query = "SELECT * FROM ".TABLE_HOUSE_DISPLAY." WHERE displayid=".$displayid." limit 0 ,1";
	$r = $db->get_one($query);
	$r = new_htmlspecialchars($r);
	@extract($r,EXTR_OVERWRITE);	
	

	$query = "SELECT * FROM ".TABLE_HOUSE_HOLD." WHERE displayid=".$displayid." ORDER BY holdid DESC";
	$holdimages = array();
	$res = $db->query($query);
	while($r = $db->fetch_array($res))
	{ 
		$holdimages[] = $r;
	}
	$db->free_result($res);
	$style_edit = style_edit("house[style]",$style);
	
	$subtypeselect = type_select('house[subtype]',"选择附属类别", $subtype);

	$displayhtmlurlruleid = $ishtml ? $urlruleid : $MOD['displayitem_html_urlruleid'];
	$displayphpurlruleid = $ishtml ?  $MOD['displayitem_php_urlruleid'] : $urlruleid ;
	$style_edit = style_edit("display[style]",$style);
	$html_urlrule = display_urlrule_select('html_urlrule','html','item',$displayhtmlurlruleid);
	$php_urlrule = display_urlrule_select('php_urlrule','php','item',$displayphpurlruleid);
	$showskin = showskin('house[skinid]',$skinid);
	$showtpl = showtpl($mod,'content','display[templateid]',$templateid);
	$position = $pos->checkbox('display[arrposid][]', $arrposid);
	include admintpl('display_edit');
}
?>