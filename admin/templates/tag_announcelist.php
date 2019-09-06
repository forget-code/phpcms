<?php include admintpl('header');?>
<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center><?=$_CHA['channelname']?>频道 - <?=$funcs[$func]?>管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=set&func=<?=$func?>&channelid=<?=$channelid?>">添加<?=$funcs[$func]?></a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&func=<?=$func?>&channelid=<?=$channelid?>">管理<?=$funcs[$func]?></a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2><?=$funcs[$func]?>设置</th>
  </tr>
  <form name="myform" method="get" action="?" onsubmit="javascript:return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="channelid" type="hidden" value="<?=$channelid?>">
   <input name="action" type="hidden" value="save">
   <input name="tagid" type="hidden" value="<?=$tagid?>">
   <input name="func" type="hidden" value="<?=$func?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
    <tr> 
      <td class="tablerow" width="40%"><b>配置名称</b><font color="red">*</font><br/>只能由字母、数字和下划线组成，例如：new_article</td>
      <td  class="tablerow">
	  <input name="tag" id="tag" type="text" size="20" value="<?=$my?><?=$tag?>" <?php if($tagid){?>disabled<?php } ?>> <input type="button" name="submit" value=" 检查是否已经存在 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=tag_exists&tag='+myform.tag.value,'tag_exists','450','160')"> <br/>
	  为避免与系统内置标签冲突，自定义标签配置名前面会自动加上 <font color="red">my_</font> 为前缀
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>配置说明</b><font color="red">*</font><br/>对标签进行简单描述（可用中文），例如：最新文章</td>
      <td  class="tablerow"><input name="tagname" id="tagname" type="text" size="60" value="<?=$tagname?>"></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>所属频道</b></td>
      <td  class="tablerow"><input name="newdata[channelid]" id="setchannelid" type="text" size="15" value="<?=$data[channelid]?>"> 
<select name='selectchannelid' onchange="javascript:myform.setchannelid.value=this.value">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($_CHANNEL as $id=>$channel)
{
	if($channel[channeltype])
	{
       $selected = $id == $channelid ? "selected" : "";
?>
<option value='<?=$id?>' <?=$selected?>><?=$channel[channelname]?></option>
<?php 
	}
}
?>
</select>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否分页</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[page]" value="1" <? if($data[page]) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="newdata[page]" value="0" <? if(!$data[page]) { ?>checked<? } ?>> 否
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每页显示公告数</b></td>
      <td  class="tablerow"><input name="newdata[announcenum]" type="text" size="5" value="<?=$data[announcenum]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>公告标题最大字符数</b></td>
      <td  class="tablerow"><input name="newdata[titlelen]" type="text" size="5" value="<?=$data[titlelen]?>"> 一个汉字=两个英文字符</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>时间显示格式</b></td>
      <td  class="tablerow">
<select name='newdata[datetype]'>
<option value='0' <? if($data[datetype]==0) { ?>selected<? } ?>>不显示时间</option>
<option value='1' <? if($data[datetype]==1) { ?>selected<? } ?>>格式：<?=date('Y-m-d',$timestamp)?></option>
<option value='2' <? if($data[datetype]==2) { ?>selected<? } ?>>格式：<?=date('m-d',$timestamp)?></option>
<option value='3' <? if($data[datetype]==3) { ?>selected<? } ?>>格式：<?=date('Y/m/d',$timestamp)?></option>
<option value='4' <? if($data[datetype]==4) { ?>selected<? } ?>>格式：<?=date('Y.m.d',$timestamp)?></option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否显示作者</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[showauthor]" value="1" <? if($data[showauthor]) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="newdata[showauthor]" value="0" <? if(!$data[showauthor]) { ?>checked<? } ?>> 否
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[target]" value="1" <? if($data[target]) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[target]" value="0" <? if(!$data[target]) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示区宽度</b></td>
      <td  class="tablerow"><input name="newdata[width]" type="text" size="5" value="<?=$data[width]?>"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示区高度</b></td>
      <td  class="tablerow"><input name="newdata[height]" type="text" size="5" value="<?=$data[height]?>"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=$showtpl?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=announce&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="Submit" value=" 保存 " onclick="javascript:doSave();">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onclick="return doPreview();">  &nbsp; 
         <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
  </form>
</table>
</body>
</html>