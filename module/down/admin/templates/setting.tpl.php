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
      <td class="tablerow"  width="20%"><strong>默认下载模式</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[mode]" value="0"  <?php if(!$mode){ ?>checked <?php } ?>> 普通模式
	  &nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="setting[mode]" value="1"  <?php if($mode){ ?>checked <?php } ?>> 镜像模式
	  &nbsp;&nbsp;&nbsp;&nbsp;
	   <input type="button"  onclick="window.location='?mod=<?=$mod?>&file=mirror_server&channelid=<?=$channelid?>';" value="镜像服务器管理">
	 </td>
    </tr>

    <tr>
      <td class="tablerow"><strong>镜像服务器端通信文件</strong></td>
      <td class="tablerow">
	  <input type="input" size="25" name="setting[mirror_file]" value="<?=$mirror_file?>">.php
	 </td>
    </tr>

    <tr>
      <td class="tablerow"><strong>镜像服务器端通信密匙</strong></td>
      <td class="tablerow">
	  <input type="input" size="25" name="setting[auth_key]" value="<?=$auth_key?>">
	 </td>
    </tr>

    <tr>
      <td class="tablerow"><strong>本地文件下载模式</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[local_showurl]" value="0"  <?php if(!$local_showurl){ ?>checked <?php } ?>> 不显示文件真实地址，用PHP读取，可在一定程度防止盗链。<br/>
	  <input type="radio" name="setting[local_showurl]" value="1"  <?php if($local_showurl){ ?>checked <?php } ?>> 用浏览器跳转至文件真实地址。
	 </td>
    </tr> 

    <tr>
      <td class="tablerow"><strong>远程文件下载模式</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[remote_showurl]" value="0"  <?php if(!$remote_showurl){ ?>checked <?php } ?>> 不显示文件真实地址，用PHP读取。严重损耗服务器资源，不推荐。<br/>
	  <input type="radio" name="setting[remote_showurl]" value="1"  <?php if($remote_showurl){ ?>checked <?php } ?>> 用浏览器跳转至文件真实地址。<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">Tips:</font>远程文件包括http,ftp等格式开头的文件地址，但此设置对镜像下载模式无效。
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
      <td class="tablerow"><strong>解压密码</strong></td>
      <td class="tablerow"><input type="text" name="setting[password]" value="<?=$password?>" size="15"> 0表示无解压密码。
	 </td>
    </tr>

    <tr>
      <td class="tablerow"><strong>下载地址有效时间</strong></td>
      <td class="tablerow"><input type="text" name="setting[expire]" value="<?=$expire?>" size="4"> 分 如果下载地址超过此时间将失效，此设置不影响已经开始下载的用户。0表示无失效时间。
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