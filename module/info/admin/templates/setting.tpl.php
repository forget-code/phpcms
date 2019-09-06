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
      <td class="tablerow"><strong>默认缩略图设置</strong></td>
      <td class="tablerow">
	  宽度:<input type="text" name="setting[thumb_width]" value="<?=$thumb_width?>" size="4"> px
	  高度:<input type="text" name="setting[thumb_height]" value="<?=$thumb_height?>" size="4"> px
	 </td>
    </tr>

	 <tr>
      <td class="tablerow"><strong>显示图片最大宽度</strong></td>
      <td class="tablerow"><input type="text" name="setting[img_maxwidth]" value="<?=$img_maxwidth?>" size="4"> px 超过此宽度可能会撑破表格，请根据页面大小合理设置
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
      <td class="tablerow"><strong>发布信息是否启用验证码</strong></td>
	  <td class="tablerow">
	  <input type="radio" name="setting[check_code]" value="1"  <?php if($check_code){ ?>checked <?php } ?>> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[check_code]" value="0"  <?php if(!$check_code){ ?>checked <?php } ?>> 否
	 </td>
    </tr>

	 <tr>
      <td class="tablerow" ><strong>发布信息扣点数</strong></td>
      <td class="tablerow">&nbsp;<input size="5" name="setting[add_point]" type="input" value="<?=$add_point?>"/> 点 Tips:0为不扣点，此设置对游客无效</td>
    </tr>

	<tr>
      <td class="tablerow"><strong>是否开启字符过滤</strong></td>
	  <td class="tablerow">
	  <input type="radio" name="setting[enable_reword]" value="1"  <?php if($enable_reword){ ?>checked <?php } ?>> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[enable_reword]" value="0"  <?php if(!$enable_reword){ ?>checked <?php } ?>> 否 此项在一定程度上影响页面生成或者显示速度
	 </td>
    </tr>

	<tr>
      <td class="tablerow"><strong>是否开启关联链接</strong></td>
	  <td class="tablerow">
	  <input type="radio" name="setting[enable_keylink]" value="1"  <?php if($enable_keylink){ ?>checked <?php } ?>> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[enable_keylink]" value="0"  <?php if(!$enable_keylink){ ?>checked <?php } ?>> 否 此项比较影响页面生成或者显示速度
	 </td>
    </tr>
<tr>
      <td class="tablerowhighlight" align="center" colspan="2">自定义添加/编辑界面</td>
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
	  宽度:<input type="input" name="setting[editor_width]" value="<?=$editor_width?>" size="5">
	  &nbsp;&nbsp;
	  高度:<input type="input" name="setting[editor_height]" value="<?=$editor_height?>" size="5"> px或百分比
	  <input type="radio" name="setting[editor_mode]" value="phpcms" <?php if($editor_mode == 'phpcms'){ ?>checked <?php } ?>> 全功能模式
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[editor_mode]" value="introduce"  <?php if($editor_mode == 'introduce'){ ?>checked <?php } ?>> 精简模式
	 </td>
   </tr>
   <tr>
      <td class="tablerowhighlight" align="center" colspan="2">RSS设置</td>
	</tr>
	<tr>
      <td class="tablerow"><strong>是否启用</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[enable_rss]" value="1"  <?php if($enable_rss){ ?>checked <?php } ?>> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[enable_rss]" value="0"  <?php if(!$enable_rss){ ?>checked <?php } ?>> 否
	 </td>
   </tr>
    <tr>
      <td class="tablerow"><strong>输出条数</strong></td>
      <td class="tablerow">
	  <input type="text" name="setting[rss_num]" value="<?=$rss_num?>" size="5">
	 </td>
   </tr>

    <tr>
      <td class="tablerow"><strong>输出截取长度</strong></td>
      <td class="tablerow">
	  <input type="text" name="setting[rss_length]" value="<?=$rss_length?>" size="5"> 留空表示不截取
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