<?php 
require '../../include/common.inc.php';
if(!$channelid) exit;
$areaid = isset($areaid) ? intval($areaid) :  0;
$AREA = cache_read('areas_'.$channelid.'.php');
$str = '<select onchange="$(\'areaid\').value=this.value;this.disabled=true;areaload(this.value);"><option value="s">'.$LANG['please_select'].'</option>';
$opt = '';
foreach($AREA as $i=>$v)
{
	if($v['parentid'] == $areaid)  $opt .= '<option value="'.$i.'">'.$v['areaname'].'</option>';
}
if(!$opt) exit;
$str = $str.$opt.'</select>';
echo $str;
?>