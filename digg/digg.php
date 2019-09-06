<?php
require './include/common.inc.php';

if(isset($flag))
{
	$data = $digg->update($contentid, $flag);
}

$r = $digg->get($contentid);
$data = $r ? ($digg->is_done($contentid) ? 1 : 0).','.$r['supports'].','.$r['againsts'] : '0,0,0';
$dig_arr = explode(',', $data);
$sup = $aga = '';
if($dig_arr[0])
{
	$aga = $sup = '<samp id="diggDivDo_down_'.$contentid.'}" ><a href="'.$MODULE['digg']['url'].'?catid='.$catid.'" target="_blank" class="orange">查看</a></samp>';
}
else
{
	$aga = '<samp id="diggDivDo_down_'.$contentid.'" onclick="digg(0)" >踩一下</samp>';
	$sup = '<samp id="diggDivDo_down_'.$contentid.'" onclick="digg(1)" >顶一下</samp>';
}
$html = "<link href=\"".SKIN_PATH."{$mod}.css\" rel=\"stylesheet\" type=\"text/css\" /><div id=\"digg\"><span><strong id=\"diggDivCount_{$contentid}\">{$dig_arr[1]}</strong><br />{$sup}</span><span class=\"cai\"><strong id=\"diggDivCount_down_{$contentid}\">{$dig_arr[2]}</strong><br /><samp id=\"diggDivDo_down_{$contentid}\" onclick=\"digg(0)\" >{$aga}</samp></span></div>";
?>
$("#digg_div").html("<?=addslashes($html)?>");
function digg(id)
{
	$("#digg_div").html('正在处理...');
	$("#calldigg_js").attr('src', "<?=$PHPCMS['siteurl']?><?=$MODULE['digg']['url']?>digg.php?contentid=" + contentid+"&catid="+catid+"&flag="+id);
}