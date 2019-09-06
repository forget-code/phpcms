<?php include admintpl('header');?>
<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
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
      <td class="tablerow" width="40%"><b>调用文章所属频道ID</b><br>如果多个频道共用同一个模板，则请使用变量<a href="#" onclick="myform.setchannelid.value='$channelid'"><font color=red>$channelid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="newdata[channelid]" type="text" size="15" value="<?=$data[channelid]?>" id="setchannelid">
<br>
<select name='selectchannelid' onchange="javascript:myform.setchannelid.value=this.value">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($_CHANNEL as $id=>$channel)
{
	if($channel[channeltype] && $channel[module]==$mod)
	{
?>
<option value='<?=$id?>'><?=$channel[channelname]?></option>
<?php 
	}
}
?>
</select>
选择时频道ID会自动加入到表单中
</td>
    </tr>
    <tr> 
      <td class="tablerow"  width="40%"><b>调用文章所属栏目ID</b><br>多个ID之前用半角逗号隔开，0表示不限栏目<br>某些情况下可使用变量<a href="#" onclick="myform.catid.value='$catid'"><font color=red>$catid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="newdata[catid]" type="text" size="20" value="<?=$data[catid]?>" id="catid">&nbsp;&nbsp;&nbsp;&nbsp;
<input name='newdata[child]' type='checkbox' value='1' <? if($data[child]==1) { ?>checked<? } ?>>调用子栏目文章（单个栏目ID有效）
<br>
<select name='selectcatid' onchange="javascript:ChangeInput(this,document.myform.catid)">
<option value='0'>请选择栏目</option>
<option value='$catid'>$catid</option>
<option value='0'>不限栏目</option>
<?=$cat_option?>
</select>
选择时栏目ID会自动加入到表单中
</td>
    </tr>
    <tr> 
      <td class="tablerow"  width="40%"><b>调用文章所属专题ID</b><br>多个ID之前用半角逗号隔开，0表示不限专题<br>某些情况下可使用变量<a href="#" onclick="myform.specialid.value='$specialid'"><font color=red>$specialid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="newdata[specialid]" type="text" size="20" value="<?=$data[specialid]?>" id="specialid">
<br>
<?=$special_select?>
选择时专题ID会自动加入到表单中
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[page]" value="$page" <? if($data[page]) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[page]" value="0" <? if(!$data[page]) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每页文章数</b></td>
      <td  class="tablerow"><input name="newdata[articlenum]" type="text" size="10" value="<?=$data[articlenum]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>文章标题最大字符数</b></td>
      <td  class="tablerow"><input name="newdata[titlelen]" type="text" size="10" value="<?=$data[titlelen]?>"> 一个汉字=两个英文字符</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>内容摘要最大字符数</b></td>
      <td  class="tablerow"><input name="newdata[descriptionlen]" type="text" size="10" value="<?=$data[descriptionlen]?>"> 一个汉字=两个英文字符</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否为推荐文章</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[iselite]" value="1" <? if($data[iselite]) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[iselite]" value="0" <? if(!$data[iselite]) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>多少天以内的文章</b></td>
      <td  class="tablerow"><input name="newdata[datenum]" type="text" size="5" value="<?=$data[datenum]?>" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0' <? if($data[datenum]==0) { ?>selected<? } ?>>不限天数</option>
<option value='3' <? if($data[datenum]==3) { ?>selected<? } ?>>3天以内</option>
<option value='7' <? if($data[datenum]==7) { ?>selected<? } ?>>一周以内</option>
<option value='14' <? if($data[datenum]==14) { ?>selected<? } ?>>两周以内</option>
<option value='30' <? if($data[datenum]==30) { ?>selected<? } ?>>一个月内</option>
<option value='60' <? if($data[datenum]==60) { ?>selected<? } ?>>两个月内</option>
<option value='90' <? if($data[datenum]==90) { ?>selected<? } ?>>三个月内</option>
<option value='180' <? if($data[datenum]==180) { ?>selected<? } ?>>半年以内</option>
<option value='365' <? if($data[datenum]==365) { ?>selected<? } ?>>一年以内</option>
</select>
您可以从下拉框中选择
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>文章排序方式</b></td>
      <td  class="tablerow">
<select name='newdata[ordertype]'>
<option value='1' <? if($data[ordertype]==1) { ?>selected<? } ?>>按文章ID降序</option>
<option value='2' <? if($data[ordertype]==2) { ?>selected<? } ?>>按文章ID升序</option>
<option value='3' <? if($data[ordertype]==3) { ?>selected<? } ?>>按更新时间降序</option>
<option value='4' <? if($data[ordertype]==4) { ?>selected<? } ?>>按更新时间升序</option>
<option value='5' <? if($data[ordertype]==5) { ?>selected<? } ?>>按点击数降序</option>
<option value='6' <? if($data[ordertype]==6) { ?>selected<? } ?>>按点击数升序</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示方式</b></td>
      <td  class="tablerow">
<input type="radio" name="newdata[showtype]" value="1" <? if($data[showtype]==1) { ?>checked<? } ?>>图片+标题+内容简介：上下排列<br>
<input type="radio" name="newdata[showtype]" value="2" <? if($data[showtype]==2) { ?>checked<? } ?>>（图片+标题：上下排列）+内容简介：左右排列<br>
<input type="radio" name="newdata[showtype]" value="3" <? if($data[showtype]==3) { ?>checked<? } ?>>图片+（标题+内容简介：上下排列）：左右排列
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否显示作者、更新时间、点击数等提示信息</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[showalt]" value="1" <? if($data[showalt]) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[showalt]" value="0" <? if(!$data[showalt]) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片宽度</b></td>
      <td  class="tablerow"><input name="newdata[imgwidth]" type="text" size="5" value="<?=$data[imgwidth]?>"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片高度</b></td>
      <td  class="tablerow"><input name="newdata[imgheight]" type="text" size="5" value="<?=$data[imgheight]?>"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示文章标题列数</b></td>
      <td  class="tablerow">
<select name='newdata[cols]'>
<option value='1' <? if($data[cols]==1) { ?>selected<? } ?>>1列</option>
<option value='2' <? if($data[cols]==2) { ?>selected<? } ?>>2列</option>
<option value='3' <? if($data[cols]==3) { ?>selected<? } ?>>3列</option>
<option value='4' <? if($data[cols]==4) { ?>selected<? } ?>>4列</option>
<option value='5' <? if($data[cols]==5) { ?>selected<? } ?>>5列</option>
<option value='6' <? if($data[cols]==6) { ?>selected<? } ?>>6列</option>
<option value='7' <? if($data[cols]==7) { ?>selected<? } ?>>7列</option>
<option value='8' <? if($data[cols]==8) { ?>selected<? } ?>>8列</option>
<option value='9' <? if($data[cols]==9) { ?>selected<? } ?>>9列</option>
<option value='10' <? if($data[cols]==10) { ?>selected<? } ?>>10列</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=$showtpl?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&channelid=<?=$channelid?>&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
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