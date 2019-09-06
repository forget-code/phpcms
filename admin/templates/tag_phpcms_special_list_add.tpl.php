<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>">管理标签</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?" onsubmit="javascript:return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>" id="action">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20"> <input type="button" value=" 检查是否已经存在 " onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checkname&tagname='+$('tagname').value+'','','300','40','no')"> <br/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>标签说明</b><br/>例如：首页最新推荐产品，10篇</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>所属频道</b></td>
      <td  class="tablerow"><input name="tag_config[keyid]" id="setchannelid" type="text" size="15" value="<?=$keyid?>"> 
<select name='selectchannelid' onchange="javascript:myform.setchannelid.value=this.value">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($CHANNEL as $id=>$channel)
{
	if($channel['islink'] == 0)
	{
       $selected = $id == $channelid ? "selected" : "";
?>
<option value='<?=$id?>' <?=$selected?>><?=$channel['channelname']?></option>
<?php 
	}
}
?>
</select>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每页专题数</b></td>
      <td  class="tablerow"><input name="tag_config[specialnum]" type="text" size="10" value="10"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>专题名称最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[specialnamelen]" type="text" size="10" value="50"> 一个汉字=两个英文字符，若为0，则不显示专题名称</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>专题介绍最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[descriptionlen]" type="text" size="10" value="200"> 一个汉字=两个英文字符，若为0，则不显示专题简介</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否为推荐专题</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[iselite]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[iselite]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>多少天以内的专题</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="5" value="30" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0'>不限天数</option>
<option value='3'>3天以内</option>
<option value='7'>一周以内</option>
<option value='14'>两周以内</option>
<option value='30'>一个月内</option>
<option value='60'>两个月内</option>
<option value='90'>三个月内</option>
<option value='180'>半年以内</option>
<option value='365'>一年以内</option>
</select>
您可以从下拉框中选择
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示方式</b></td>
      <td  class="tablerow">
<input type="radio" name="tag_config[showtype]" value="1" checked>图片+专题名称+专题简介：上下排列<br>
<input type="radio" name="tag_config[showtype]" value="2">（图片+专题名称：上下排列）+专题简介：左右排列<br>
<input type="radio" name="tag_config[showtype]" value="3">图片+（专题名称+专题简介：上下排列）：左右排列<br>
<input type="radio" name="tag_config[showtype]" value="4">专题名称+（图片+专题简介：左右排列）：上下排列<br>
<input type="radio" name="tag_config[showtype]" value="5">专题名称+（图片+专题简介：混合排列）：上下排列<br>
<input type="radio" name="tag_config[showtype]" value="6">专题名称+专题简介：上下排列
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片宽度</b></td>
      <td  class="tablerow"><input name="tag_config[imgwidth]" type="text" size="5" value="150"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片高度</b></td>
      <td  class="tablerow"><input name="tag_config[imgheight]" type="text" size="5" value="150"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示专题列数</b></td>
      <td  class="tablerow">
<select name='tag_config[cols]'>
<option value='1'>1列</option>
<option value='2'>2列</option>
<option value='3'>3列</option>
<option value='4'>4列</option>
<option value='5'>5列</option>
<option value='6'>6列</option>
<option value='7'>7列</option>
<option value='8'>8列</option>
<option value='9'>9列</option>
<option value='10'>10列</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod, 'tag_special_list', 'tag_config[templateid]', 0 ,' id="templateid" ')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=phpcms&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr>
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='add';">
&nbsp;
<input name="submit" type="submit" onclick="$('action').value='preview';" value=" 预览 ">
&nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>