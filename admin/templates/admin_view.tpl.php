<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">查看管理员 <?=$username?> 的权限</th>
  </tr>
    <tr> 
      <td width="12%" class="tablerow">用户名</td>
      <td class="tablerow"><?=$username?></td>
    </tr>
	<tr> 
      <td class="tablerow">管理员级别</td>
      <td class="tablerow"><?=$grades[$grade]?></td>
    </tr>
<?php if($grade > 0){ ?>
<tbody id="select_channel" style="display:">
<?php }else{ ?>
<tbody id="select_channel" style="display:none">
<?php } ?>
	<tr> 
	<td width="20%" class="tablerow">频道权限</td>
	<td class="tablerow">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php 
if(is_array($CHANNEL)){
	foreach($CHANNEL as $channel){
		if(!$channel['islink']){
?>
  <tr>
    <td height="25"><input name="channel[<?=$channel['channelid']?>]" id="channel<?=$channel['channelid']?>"  type="checkbox" value="<?=$channel['channelid']?>" <?php if(in_array($channel['channelid'], $channels)){ ?>checked <?php } ?>><?=$channel['channelname']?>频道 <br/></td>
  </tr>
  <tr id='table_<?=$channel['channelid']?>' style='display:<?=($grade > 2 && in_array($channel['channelid'], $channels)) ? '' : 'none'?>'>
    <td><iframe id='frm_<?=$channel['channelid']?>' height='200' width='100%' src='?mod=<?=$mod?>&file=<?=$file?>&action=purview_category&channelid=<?=$channel['channelid']?>&catids=<?=$catids?>'></iframe></td>
  </tr>
<?php 
		}
	}
}
?>
</table>
	</td>
	</tr>
</tbody>
<?php if($grade == 1){ ?>
<tbody id="select_module" style="display:">
<?php }else{ ?>
<tbody id="select_module" style="display:none">
<?php } ?>
	<tr> 
	<td class="tablerow">模块权限</td>
	<td class="tablerow">

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php 
if(is_array($MODULE)){
	$k=0;
	foreach($MODULE as $module=>$m){
		if($m['iscopy']==0 && $m['isshare']==0 && $module!='phpcms'){
		if($k%4==0) echo "<tr>";
?>
    <td height="25"><input size=50 name="module[]" type="checkbox" value="<?=$module?>" <?php if(in_array($module,$modules)){ ?>checked <?php } ?>><?=$m['name']?></td>
<?php 
		if($k%4==3) echo "</tr>";
	    $k++;
		}
	}
}
?>
</table>

	</td>
	</tr>
</tbody>
</table>
</body>
</html>