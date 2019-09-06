<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
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
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
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
  <form name="myform" method="get" action="?" onsubmit="return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="keyid" type="hidden" value="<?=$keyid?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
   <input name="referer" type="hidden" value="<?=$forward?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>"> <input type="button" name="submit" value=" 检查是否已经存在 " onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checkname&tagname='+$('tagname').value+'','','300','40','no')"> <br/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页推荐链接，10条</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" ></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>

    <tr> 
      <td class="tablerow" width="40%"><b>所属模块或频道id</b><br><font color="blue">多个ID之前用半角逗号隔开，0表示不限模块</font><br>某些情况下可使用变量<a href="###" onclick="$('keytype').value='$keyid'"><font color="red">$keyid</font></a>作为参数</td>
      <td  class="tablerow"><input name="tag_config[keyid]" type="text" size="35" value="<?=$keyid?>" id="keytype"> <?=keyid_select('qw','','','onchange="ChangeInput(this,document.myform.keytype)"')?></td>
	</tr>
	
	<tr> 
      <td class="tablerow" width="40%"><b>调用留言数目</b></td>
      <td  class="tablerow"><input name="tag_config[guestbooknum]" type="text" size="5" value="10"> </td>
    </tr>
	 <tr> 
      <td class="tablerow" width="40%"><b>留言标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[subjectlen]" type="text" size="5" value="50"> </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>时间显示格式</b></td>
      <td  class="tablerow">
	  <select name="tag_config[datetype]">
	<option value="0">不显示时间</option>
	<option value="1">格式：2007-01-11</option>
	<option value="2">格式：01-11</option>
	<option value="3">格式：2007/01/11</option>
	<option value="4">格式：2007.01.11</option>
	<option value="5">格式：2007-01-11 21:24:19</option>
	<option value="6">格式：2007-01-11 21:24</option>
	</select>
      </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>是否在标题后面显示用户名</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showusername]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showusername]" value="0" checked>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每行显示留言列数</b></td>
      <td  class="tablerow">
<select name='tag_config[cols]'>
<option value='1' >1列</option>
<option value='2' >2列</option>
<option value='3' >3列</option>
<option value='4' >4列</option>
<option value='5' >5列</option>
<option value='6' >6列</option>
<option value='7' >7列</option>
<option value='8' >8列</option>
<option value='9' >9列</option>
<option value='10' >10列</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod,'tag_guestbook_list','tag_config[templateid]','','id=templateid')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=guestbook&forward=<?=urlencode($PHP_URL)?>'"> 【注:只能修改非默认模板】
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