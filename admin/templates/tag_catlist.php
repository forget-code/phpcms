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
      <td class="tablerow"  width="40%"><b>调用哪个栏目的子栏目列表</b></td>
      <td  class="tablerow">
<select name='newdata[catid]' onchange="javascript:ChangeInput(this,document.myform.catid)">
<option value='0'>所有栏目</option>
<?=$cat_option?>
</select>
<input name='newdata[child]' type='checkbox' value='1' <? if($data[child]==1) { ?>checked<? } ?>>是否显示子栏目的下级栏目
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>栏目显示方式</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[showtype]" value="0" <? if($data[showtype]==0) { ?>checked<? } ?>> 树型导航菜单样式&nbsp;&nbsp;<input name='newdata[open]' type='checkbox' value='1' <? if($data[open]==1) { ?>checked<? } ?>>是否默认展开所有栏目<br>
                            <input type="radio" name="newdata[showtype]" value="1" <? if($data[showtype]==1) { ?>checked<? } ?>> <b>子栏目一</b>：下级栏目一&nbsp;|&nbsp;下级栏目二<br>&nbsp;&nbsp;&nbsp;&nbsp;<b>子栏目二</b>：下级栏目一&nbsp;|&nbsp;下级栏目二<br>
                            <input type="radio" name="newdata[showtype]" value="2" <? if($data[showtype]==2) { ?>checked<? } ?>> <b>子栏目一</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>子栏目二</b><br>&nbsp;&nbsp;&nbsp;&nbsp;子栏目一下级&nbsp;&nbsp;子栏目一下级

      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=$showtpl?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=phpcms&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
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