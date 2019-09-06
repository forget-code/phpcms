<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function doCheck(){
	if($F('tagname')==''){
		alert('标签名称不能为空');
		$('tagname').focus();
		return false;
	}
	return true;
}
</script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>&keyid=<?=$keyid?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>&keyid=<?=$keyid?>">管理标签</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?"  onsubmit="return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
    <tr>
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>"> <input type="button" name="submit" value=" 检查是否已经存在 " onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checkname&tagname='+$('tagname').value+'','','300','40','no')"> <br/>
	  </td>
    </tr>
    <tr>
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页显示公告，10条</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" ></td>
    </tr>
    <tr>
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>

    <tr>
      <td class="tablerow" width="40%"><b>是否分页</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="1"> 是&nbsp;&nbsp;
                            <input type="radio" name="tag_config[page]" value="0" checked="checked"> 否<br>
      </td>
    </tr>

    <tr>
      <td class="tablerow" width="40%"><b>所属模块或频道ID</b></td>
      <td  class="tablerow"><input name="tag_config[keyid]" type="text" size="10" value="<?=$keyid?>" id="keytype"> <?=keyid_select('qw','','','onchange="document.myform.keytype.value=this.value"')?>【 0 则调用所有】</td>
	</tr>

	<tr>
      <td class="tablerow" width="40%"><b>每页显示公告数</b></td>
      <td  class="tablerow"><input name="tag_config[announcenum]" type="text" size="5" value="10"> </td>
    </tr>
	 <tr>
      <td class="tablerow" width="40%"><b>公告标题长度</b></td>
      <td  class="tablerow"><input name="tag_config[subjectlen]" type="text" size="5" value="50"> </td>
    </tr>
	<tr>
      <td class="tablerow" width="40%"><b>时间显示格式</b></td>
      <td  class="tablerow">
<select name='tag_config[datetype]'>
<option value='0' >不显示时间</option>
<option value='1' selected>格式：2007-01-11</option>
<option value='2' >格式：01-11</option>
<option value='3' >格式：2007/01/11</option>
<option value='4' >格式：2007.01.11</option>
</select>
      </td>
    </tr>
    <tr>
      <td class="tablerow" width="40%"><b>是否显示作者</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showauthor]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showauthor]" value="0" checked>否
      </td>
    </tr>
    <tr>
      <td class="tablerow" width="40%"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" >否</td>
    </tr>
    <tr>
      <td class="tablerow" width="40%"><b>显示区宽度</b></td>
      <td  class="tablerow"><input name="tag_config[width]" type="text" size="5" value="180"> px</td>
    </tr>
    <tr>
      <td class="tablerow" width="40%"><b>显示区高度</b></td>
      <td  class="tablerow"><input name="tag_config[height]" type="text" size="5" value="100"> px</td>
    </tr>
    <tr>
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod,'tag_announce_list','tag_config[templateid]','tag_announce_list','id=templateid')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=announce&forward=<?=urlencode($PHP_URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
    <tr>
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 " onclick="$('action').value='add';">   &nbsp;
         <input type="submit" name="dopreview" value=" 预览 " onclick="$('action').value='preview';">
          <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
  </form>
</table>
</body>
</html>