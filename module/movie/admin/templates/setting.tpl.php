<?php defined("IN_PHPCMS") or exit("Access Denied");
include admintpl("header");
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
   <th colspan="2"><?=$MODULE[$mod]['name']?>模块配置</th>
    <tr>
      <td class="tablerow"  width="25%"><strong>默认播放器模式</strong></td>
      <td class="tablerow">
	 <input type="radio" name="setting[choose_mode]" value="1"  <?php if($choose_mode){ ?>checked <?php } ?>> 自动
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[choose_mode]" value="0"  <?php if(!$choose_mode){ ?>checked <?php } ?>> 手动
	  &nbsp;&nbsp;&nbsp;&nbsp;自动选择模式：系统按照影片格式自动选择适合的播放器</td>
    </tr>
    <tr>
      <td class="tablerow"><strong>默认播放器</strong></td>
      <td class="tablerow">
	 <?=$player_select?>
	 </td>
    </tr>
	 <tr>
      <td class="tablerow"><strong>默认服务器</strong></td>
      <td class="tablerow">
	 <?=$server_select?>
	 </td>
    </tr>
   <tr>
      <td class="tablerow"><strong>默认点击数</strong></td>
      <td class="tablerow"><input type="text" name="setting[hits]" value="<?=$hits?>" size="15"> 
	 </td>
    </tr>
	<tr>
      <td class="tablerow"><strong>默认影片类型</strong></td>
      <td class="tablerow"><input type="text" name="setting[extension]" value="<?=$extension?>" size="15"> 
	 </td>
    </tr>
	<tr>
      <td class="tablerow"><strong>默认观看方式</strong></td>
      <td class="tablerow">
		<input type="checkbox" name="setting[onlineview]" value="1" <?php if($onlineview){?>checked <?php } ?>> 在线播放
		<input type="checkbox" name="setting[allowdown]" value="1" <?php if($allowdown){?>checked <?php } ?>> 允许下载
	 </td>
    </tr>
		<tr>
      <td class="tablerow"><strong>默认连载状态</strong></td>
      <td class="tablerow">
	  <input name="setting[serialization]" type="radio"  value="0" <?php if(!$serialization){?>checked <?php } ?>/> 连载中
	<input name="setting[serialization]" type="radio"  value="1" <?php if($serialization){?>checked <?php } ?>/> 连载完成 
	 </td>
    </tr>

	<tr>
      <td class="tablerow"><strong>关键字添加</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[keywords_show]" value="1"  <?php if($keywords_show){ ?>checked <?php } ?>> 显示
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[keywords_show]" value="0"  <?php if(!$keywords_show){ ?>checked <?php } ?>> 不显示
	  &nbsp;&nbsp;/&nbsp;&nbsp;
	  
	  <input type="radio" name="setting[keywords_add]" value="1"  <?php if($keywords_add){ ?>checked <?php } ?>> 自动
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[keywords_add]" value="0"  <?php if(!$keywords_add){ ?>checked <?php } ?>> 手动
	 </td>
   </tr>

<tr>
      <td class="tablerow"><strong>编辑器</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[editor_mode]" value="phpcms" <?php if($editor_mode == 'phpcms'){ ?>checked <?php } ?>> FCK全功能模式
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[editor_mode]" value="introduce"  <?php if($editor_mode == 'introduce'){ ?>checked <?php } ?>> FCK精简模式
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[editor_mode]" value="editor" <?php if($editor_mode == 'editor'){ ?>checked <?php } ?>> PHPCMS编辑器模式<br/>
	  宽度:<input type="input" name="setting[editor_width]" value="<?=$editor_width?>" size="5">
	  &nbsp;&nbsp;
	  高度:<input type="input" name="setting[editor_height]" value="<?=$editor_height?>" size="5"> px或百分比
	 </td>
   </tr>
    <tr>
      <td class="tablerow"><strong>默认大缩略图设置</strong></td>
      <td class="tablerow">
	  宽度:<input type="text" name="setting[bigthumb_width]" value="<?=$bigthumb_width?>" size="4"> px
	  高度:<input type="text" name="setting[bigthumb_height]" value="<?=$bigthumb_height?>" size="4"> px
	 </td>
    </tr>
	 <tr>
      <td class="tablerow"><strong>默认小缩略图设置</strong></td>
      <td class="tablerow">
	  宽度:<input type="text" name="setting[thumb_width]" value="<?=$thumb_width?>" size="4"> px
	  高度:<input type="text" name="setting[thumb_height]" value="<?=$thumb_height?>" size="4"> px
	 </td>
    </tr>
		<tr>
      <td class="tablerow"><strong>允许游客发布信息</strong></td>
	  <td class="tablerow">
	  <input type="radio" name="setting[enable_guest_add]" value="1"  <?php if($enable_guest_add){ ?>checked <?php } ?>> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[enable_guest_add]" value="0"  <?php if(!$enable_guest_add){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class="tablerow"><strong>投稿是否启用验证码</strong></td>
	  <td class="tablerow">
	  <input type="radio" name="setting[check_code]" value="1"  <?php if($check_code){ ?>checked <?php } ?>> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[check_code]" value="0"  <?php if(!$check_code){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
    <tr>
      <td class="tablerow"><strong>投稿增加点数</strong></td>
      <td class="tablerow">
	  <input type="input" name="setting[add_point]" value="<?=$add_point?>" size="5"> 0 表示不增加
	 </td>
    </tr>
	<tr>
      <td class="tablerow"><strong>影片播放地址有效时间</strong></td>
      <td class="tablerow"><input type="text" name="setting[expire]" value="<?=$expire?>" size="10"> 秒 ，0表示无失效时间。
	 </td>
    </tr>
	<tr>
      <td class="tablerow"><strong>是否整合VirtualWall防盗链软件</strong></td>
      <td class="tablerow"><input type="radio" name="setting[enable_virtualwall]" value="1"  <?php if($enable_virtualwall){ ?>checked <?php } ?> onclick="virtualwall_auth_key.style.display='block'"> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[enable_virtualwall]" value="0"  <?php if(!$enable_virtualwall){ ?>checked <?php } ?>  onclick="virtualwall_auth_key.style.display='none'"> 否 &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.fangdaolian.com/" target="_blank"><font color="red">点击了解VirtualWall防盗链软件</font></a>
	 </td>
    </tr>
	<tr id="virtualwall_auth_key" style="display:<?=($enable_virtualwall ? 'block' : 'none')?>">
      <td class="tablerow"><strong>防盗链软件通信密钥</strong></td>
      <td class="tablerow"><input type="text" name="setting[auth_key]" value="<?=$auth_key?>" size="20"> 必须和防盗链软件密钥保持一致
	 </td>
    </tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="40%"></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>