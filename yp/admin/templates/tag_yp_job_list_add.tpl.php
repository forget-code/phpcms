<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript">
function doCheck(){
	if($F('tagname')==''){
		alert('标签名称不能为空');
		$('tagname').focus();
		return false;
	}
	if($F('setchannelid')=='' || $F('setchannelid')=='0'){
		alert('频道ID不能为空和0！');
		$('setchannelid').focus();
		return false;
	}
	return true;
}
function showcat(keyid,catid)
{
    var url = "<?=$PHP_SELF?>";
    var pars = "mod=phpcms&file=tag&action=category_select&catid="+catid+"&keyid="+keyid;
	var myAjax = new Ajax.Updater(
					'category_select',
					url,
					{
					method: 'get',
					parameters: pars
					}
	             ); 
}
</script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>&channelid=<?=$channelid?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>&channelid=<?=$channelid?>">管理标签</a></td>
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
      <td class="tablerow"><b>标签说明</b><br/>例如：首页最新推荐招聘，10篇</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>

    <tr> 
      <td class="tablerow"><b>调用所属岗位</b></td>
      <td  class="tablerow"><?=$station_select?></td>
    </tr>
  
    <tr> 
      <td class="tablerow"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" checked>否</td>
    </tr>
	<tr> 
      <td class="tablerow" width="40%"><b>是否为推荐</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[elite]" value="1" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[elite]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>调用招聘数或每页招聘数</b></td>
      <td  class="tablerow"><input name="tag_config[jobnum]" type="text" size="10" value="10"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>招聘标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="30"> 一个汉字为2个字符</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>内容摘要最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[introducelen]" type="text" size="10" value="0"> 如果设置为0则表示不显示内容摘要</td>
    </tr>
  
    <tr> 
      <td class="tablerow"><b>推荐位置</b></td>
      <td  class="tablerow"><?=pos_select($channelid, "tag_config[posid]", "不限", 0)?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>多少天以内的招聘</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="10" value="0" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name="selectdatenum" onchange="$('datenum').value=this.value">
<option value="0">不限天数</option>
<option value="3">3天以内</option>
<option value="7">一周以内</option>
<option value="14">两周以内</option>
<option value="30">一个月内</option>
<option value="60">两个月内</option>
<option value="90">三个月内</option>
<option value="180">半年以内</option>
<option value="365">一年以内</option>
</select>
您可以从下拉框中选择
</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>招聘排序方式</b></td>
      <td  class="tablerow">
<select name="tag_config[ordertype]">
<option value="0">按招聘排序排序</option>
<option value="1">按更新时间降序</option>
<option value="2">按更新时间升序</option>
<option value="3">按浏览次数降序</option>
<option value="4">按浏览次数升序</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>时间显示格式</b></td>
      <td  class="tablerow">
	  <select name="tag_config[datetype]">
	<option value="0">不显示时间</option>
	<option value="1">格式：<?=date("Y-m-d",$PHP_TIME)?></option>
	<option value="2">格式：<?=date("m-d",$PHP_TIME)?></option>
	<option value="3">格式：<?=date("Y/m/d",$PHP_TIME)?></option>
	<option value="4">格式：<?=date("Y.m.d",$PHP_TIME)?></option>
	<option value="5">格式：<?=date("Y-m-d H:i:s",$PHP_TIME)?></option>
	<option value="6">格式：<?=date("Y-m-d H:i",$PHP_TIME)?></option>
	</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在招聘标题前显示岗位名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showstationname]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showstationname]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在标题后面显示作者</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showauthor]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showauthor]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在标题后面显示浏览次数</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showhits]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showhits]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" >否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>每行显示链接列数</b></td>
      <td  class="tablerow"><input name="tag_config[cols]" type="text" size="5" id="cols" value="1">&nbsp;<select name="selectcols" onchange="$('cols').value=this.value">
<option value="1">1列</option>
<option value="2">2列</option>
<option value="3">3列</option>
<option value="4">4列</option>
<option value="5">5列</option>
<option value="6">6列</option>
<option value="7">7列</option>
<option value="8">8列</option>
<option value="9">9列</option>
<option value="10">10列</option>
</select>
      </td>
    </tr>

 <tr> 
  <td class="tablerow"><b>会员名称</b></td>
  <td  class="tablerow"><input name="tag_config[username]" id="username" type="text" size="15" /> 可调用单个会员的招聘</td>
</tr>

    <tr> 
      <td class="tablerow"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_job_list','tag_config[templateid]')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=yp&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 " onclick="$('action').value='add';">   &nbsp; 
         <input type="submit" value=" 预览 " onclick="$('action').value='preview';">  &nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>