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
<input type="hidden" name="up_dir" value="<?=$upload_dir?>">
<table cellpadding="2" cellspacing="1" class="tableborder">

   <th colspan="2"><?=$MODULE[$mod]['name']?>模块配置</th>

  	<tr>
      <td class="tablerow"><strong>默认上传目录</strong></td>
      <td class="tablerow"><input type="text" name="setting[upload_dir]" value="<?=$upload_dir?>" size="20"> 您可以随时更改此目录使得外部盗链地址失效。<br/><font color="red">请注意:如果该频道选择了生成html，则重名名此目录后需重新生成图片信息，否则将导致静态页面图片无法显示！</font>
	 </td>
    </tr>

	<tr>
      <td class="tablerow"><strong>图片显示方式</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[show_mode]" value="0"  <?php if(!$show_mode){ ?>checked <?php } ?>> 直接显示 可通过重命名上传目录使得外部盗链地址失效，但静态页面需重新生成图片信息
	 <br/><input type="radio" name="setting[show_mode]" value="1"  <?php if($show_mode){ ?>checked <?php } ?>> PHP读取
	 可在一定程度防止外部盗链，但将增加服务器压力，亦不利搜索引擎抓取
	  </td>
   </tr>

      <tr>
      <td class="tablerow"><strong>默认缩略图设置</strong></td>
      <td class="tablerow">
	  宽度:<input type="text" name="setting[thumb_width]" value="<?=$thumb_width?>" size="4"> px
	  高度:<input type="text" name="setting[thumb_height]" value="<?=$thumb_height?>" size="4"> px
	 </td>
    </tr>
	 <tr>
      <td class="tablerow"><strong>平铺图片最大宽度</strong></td>
      <td class="tablerow"><input type="text" name="setting[thumb_maxwidth]" value="<?=$thumb_maxwidth?>" size="4"> px 缩略图平铺时超过此宽度，将等比缩小
	 </td>
    </tr>

	 <tr>
      <td class="tablerow"><strong>显示图片最大宽度</strong></td>
      <td class="tablerow"><input type="text" name="setting[img_maxwidth]" value="<?=$img_maxwidth?>" size="4"> px 单图片显示时，超过此宽度可能会撑破表格，请根据页面大小合理设置
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
      <td class="tablerow"><strong>投稿增加点数</strong></td>
	  <td class="tablerow"><input type="text" name="setting[add_point]" value="<?=$add_point?>" size="5"> 0表示不增加
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
      <td class="tablerow"><strong>作者添加</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[author_show]" value="1"  <?php if($author_show){ ?>checked <?php } ?>> 显示
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[author_show]" value="0"  <?php if(!$author_show){ ?>checked <?php } ?>> 不显示
	  &nbsp;&nbsp;/&nbsp;&nbsp;
	  
	  <input type="radio" name="setting[author_add]" value="1"  <?php if($author_add){ ?>checked <?php } ?>> 自动
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[author_add]" value="0"  <?php if(!$author_add){ ?>checked <?php } ?>> 手动
	 </td>
   </tr>


	<tr>
      <td class="tablerow"><strong>来源添加</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[copyfrom_show]" value="1"  <?php if($copyfrom_show){ ?>checked <?php } ?>> 显示
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[copyfrom_show]" value="0"  <?php if(!$copyfrom_show){ ?>checked <?php } ?>> 不显示
	  &nbsp;&nbsp;/&nbsp;&nbsp;
	  
	  <input type="radio" name="setting[copyfrom_add]" value="1"  <?php if($copyfrom_add){ ?>checked <?php } ?>> 自动
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[copyfrom_add]" value="0"  <?php if(!$copyfrom_add){ ?>checked <?php } ?>> 手动
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
      <td class="tablerow"><strong>默认上传模式</strong></td>
      <td class="tablerow">
	 <input type="radio" value="1" name="setting[uptype]" <?php if($uptype==1) echo 'checked';?>> 本地上传
	<input type="radio" value="2" name="setting[uptype]" <?php if($uptype==2) echo 'checked';?>> 远程获取
	<input type="radio" value="3" name="setting[uptype]" <?php if($uptype==3) echo 'checked';?>> 批量上传
	 </td>
    </tr>


    <tr>
      <td class="tablerow"><strong>默认批量上传个数</strong></td>
      <td class="tablerow"><input type="text" name="setting[upnum]" value="<?=$upnum?>" size="4"> 个
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