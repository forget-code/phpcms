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
  <form name="myform" method="get" action="?"   onsubmit="return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="channelid" type="hidden" value="<?=$channelid?>">
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input type="hidden" name="tag_config[func]" value="<?=$function?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>"> <input type="button" value=" 检查是否已经存在 " onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checkname&channelid=<?=$channelid?>&tagname='+$('tagname').value+'','','300','40','no')"> <br/>
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
      <td class="tablerow" width="40%"><b>所属模块/频道</b></td>
      <td  class="tablerow"><input name="tag_config[keyid]" id="keyid" type="text" size="15"> 
<?=keyid_select('setkeyid', '请选择模块/频道', '', 'onchange="javascript:myform.keyid.value=this.value"')?>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod, 'tag_type', 'tag_config[templateid]', 0 ,' id="templateid" ')?>
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